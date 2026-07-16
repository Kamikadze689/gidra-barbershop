<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Master;
use App\Models\Service;
use App\Models\Review;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Request $request, Master $master = null)
    {
        $masters = Master::all();
        $services = Service::orderBy('sort_order')->get();
        
         
        $preselectedMaster = $master ? $master->id : $request->query('master_id');
        
        return view('pages.booking', compact('masters', 'services', 'preselectedMaster'));
    }

    public function store(Request $request)
    {
         
        $request->validate([
            'g-recaptcha-response' => 'required|captcha'
        ], [
            'g-recaptcha-response.required' => 'Подтвердите, что вы не робот',
            'g-recaptcha-response.captcha' => 'Ошибка проверки капчи'
        ]);
        
         
        $phone = preg_replace('/[^0-9]/', '', $request->customer_phone);
        
        $data = $request->validate([
            'master_id'     => 'required|exists:masters,id',
            'service_ids'   => 'required|array|min:1',
            'service_ids.*' => 'exists:services,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone'=> 'required|string|max:20',
            'customer_email'=> 'nullable|email',
            'start_time'    => 'required|date|after:now',
        ]);
        
        $data['customer_phone'] = $phone;

        $master = Master::findOrFail($data['master_id']);
        $services = Service::whereIn('id', $data['service_ids'])->get();

        $start = Carbon::parse($data['start_time']);
        $totalDuration = $services->sum('duration');
        $end = $start->copy()->addMinutes($totalDuration);

         
        $overlap = Booking::where('master_id', $data['master_id'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($start, $end) {
                $q->where('start_time', '<', $end)
                  ->where('end_time', '>', $start);
            })->exists();

        if ($overlap) {
            return back()->withErrors(['start_time' => 'Это время уже занято']);
        }

         
        $booking = Booking::create([
            'master_id'      => $data['master_id'],
            'customer_name'  => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'customer_email' => $data['customer_email'] ?? null,
            'start_time'     => $start,
            'end_time'       => $end,
            'status'         => 'pending'
        ]);

        $booking->services()->attach($data['service_ids']);

        return redirect()->route('home')
                        ->with('success', 'Заявка на запись отправлена! Мы свяжемся с вами в ближайшее время для подтверждения.');
    }

    public function availableSlots(Request $request)
    {
        $masterId = $request->master_id;
        $dateStr = $request->date;

        if (!$masterId || !$dateStr) {
            return response()->json([]);
        }

        $selectedDate = Carbon::parse($dateStr)->startOfDay();
        $now = Carbon::now();

        $bookings = Booking::where('master_id', $masterId)
            ->whereDate('start_time', $selectedDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        $allSlots = ['09:00', '10:30', '12:00', '13:30', '15:00', '16:30', '18:00', '19:30'];
        $availableSlots = [];

        foreach ($allSlots as $slot) {
            $slotStart = Carbon::parse($selectedDate->format('Y-m-d') . ' ' . $slot);
            $slotEnd = $slotStart->copy()->addMinutes(90);
            
            $isBooked = false;
            foreach ($bookings as $booking) {
                $bookingStart = Carbon::parse($booking->start_time);
                $bookingEnd = Carbon::parse($booking->end_time);
                
                if ($slotStart < $bookingEnd && $slotEnd > $bookingStart) {
                    $isBooked = true;
                    break;
                }
            }
            
            if (!$isBooked) {
                if ($selectedDate->isToday()) {
                    if ($slotStart > $now->copy()->addMinutes(30)) {
                        $availableSlots[] = $slot;
                    }
                } else {
                    $availableSlots[] = $slot;
                }
            }
        }

        return response()->json($availableSlots);
    }

    public function showReviewForm($token)
    {
        $booking = Booking::where('review_token', $token)
            ->where('status', 'completed')
            ->where('review_sent', false)
            ->firstOrFail();
        
        if ($booking->review) {
            return redirect()->route('home')->with('error', 'Вы уже оставили отзыв');
        }
        
        return view('pages.review-form', compact('booking'));
    }
    
    public function storeReview(Request $request, $token)
    {
        $booking = Booking::where('review_token', $token)
            ->where('status', 'completed')
            ->where('review_sent', false)
            ->firstOrFail();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'text' => 'required|string|min:10|max:1000',
        ]);
        
        $review = Review::create([
            'booking_id' => $booking->id,
            'name' => $request->name,
            'text' => $request->text,
            'date' => now(),
            'approved' => false,
        ]);
        
        $booking->update(['review_sent' => true]);
        
        return redirect()->route('home')->with('success', 'Спасибо за отзыв! Он будет опубликован после проверки.');
    }
}