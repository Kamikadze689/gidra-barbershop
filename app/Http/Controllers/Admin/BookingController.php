<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Master;
use App\Models\Service;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BookingsExport;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['master', 'services'])->latest()->get();
        return view('admin.bookings', compact('bookings'));
    }

    public function updateStatus(Booking $booking, Request $request)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,completed,cancelled']);
        
        $oldStatus = $booking->status;
        $booking->update(['status' => $request->status]);
        
         
        if ($request->status == 'completed' && $oldStatus != 'completed' && !$booking->review_sent) {
             
            $token = $booking->generateReviewToken();
            
             
            if ($booking->customer_email) {
                \Mail::to($booking->customer_email)->send(new \App\Mail\ReviewRequestMail($booking, $token));
            }
             
        }
        
        return back()->with('success', 'Статус обновлён');
    }
    
    public function destroy(Booking $booking)
    {
         
        $booking->services()->detach();
        
         
        if ($booking->review) {
            $booking->review->delete();
        }
        
         
        $booking->delete();
        
        return redirect()->route('admin.bookings')->with('success', 'Запись успешно удалена');
    }

     
    public function generateReviewLink(Booking $booking)
    {
        if (!$booking->review_token) {
            $booking->generateReviewToken();
        }
        
        $reviewLink = route('review.form', $booking->review_token);
        
        return back()->with('success', 'Ссылка для отзыва: ' . $reviewLink);
    }

    public function exportForm()
    {
        $masters = Master::orderBy('name')->get();
        $services = Service::orderBy('title')->get();

        return view(
            'admin.bookings-export',
            compact('masters', 'services')
        );
    }
    
    public function export(Request $request)
    {
        return Excel::download(
            new BookingsExport($request),
            'bookings.xlsx'
        );
    }
}