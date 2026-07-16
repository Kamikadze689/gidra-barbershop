<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\Master;
use App\Models\Service;
use App\Models\Review;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
    Master::create([
        'name' => 'Никита Золотарёв',
        'slug' => 'nikita-zolotarev',
        'experience' => 'Топ-мастер',
        'specialization' => 'Fade, борода',
        'photo' => '/images/master.jpg',
        'review_link' => 'https://n1303781.yclients.com/company/1188423/personal/select-master/master-info/1188423/5004242?o=m4904973'
    ]);

    Master::create([
        'name' => 'Анастасия Симанова',
        'slug' => 'anastasiya-simanova',
        'experience' => 'Мастер',
        'specialization' => 'Классические стрижки',
        'photo' => '/images/master2.jpg',
        'review_link' => 'https://n1303781.yclients.com/company/1188423/personal/select-master/master-info/1188423/3600778?o=m4904973'
    ]);

    Master::create([
        'name' => 'Виктория Чащихина',
        'slug' => 'viktoriya-chashchihina',
        'experience' => 'Младший мастер',
        'specialization' => 'Борода и уход',
        'photo' => '/images/master3.jpg',
        'review_link' => 'https://n1303781.yclients.com/company/1188423/personal/select-master/master-info/1188423/3600882?o=m4904973'
    ]);

    Master::create([
        'name' => 'Жумагуль Есимханова',
        'slug' => 'zhumagul-esimhanova',
        'experience' => 'Младший мастер',
        'specialization' => 'Современные стрижки',
        'photo' => '/images/master4.jpg',
        'review_link' => 'https://n1303781.yclients.com/company/1188423/personal/select-master/master-info/1188423/4904973?o=m4904973'
    ]);

        
        Service::create(['title' => 'Мужская стрижка', 'category' => 'Основные услуги', 'price_men' => 1100, 'price_master' => 1400, 'price_top' => 1700, 'duration' => 60]);
        Service::create(['title' => 'Комплекс (стрижка + борода)', 'category' => 'Основные услуги', 'price_men' => 1600, 'price_master' => 2000, 'price_top' => 2400, 'duration' => 90]);
        Service::create(['title' => 'Борода', 'category' => 'Основные услуги', 'price_men' => 600, 'price_master' => 700, 'price_top' => 800, 'duration' => 45]);
        Service::create(['title' => 'Одна насадка', 'category' => 'Основные услуги', 'price_men' => 600, 'price_master' => 800, 'price_top' => 1000, 'duration' => 30]);
        Service::create(['title' => 'Детская стрижка', 'category' => 'Основные услуги', 'price_men' => 900, 'price_master' => 1100, 'price_top' => 1300, 'duration' => 45]);
        Service::create(['title' => 'Мытьё, укладка', 'category' => 'Дополнительные услуги', 'price_men' => 500, 'price_master' => 500, 'price_top' => 600, 'duration' => 30]);
        Service::create(['title' => 'Тонировка', 'category' => 'Дополнительные услуги', 'price_men' => 600, 'price_master' => 700, 'price_top' => 800, 'duration' => 45]);
        Service::create(['title' => 'Патчи', 'category' => 'Дополнительные услуги', 'price_men' => 200, 'price_master' => 200, 'price_top' => 200, 'duration' => 20]);
        Service::create(['title' => 'Маска', 'category' => 'Дополнительные услуги', 'price_men' => 200, 'price_master' => 200, 'price_top' => 200, 'duration' => 20]);

        
        $reviewsData = [
            ['name' => 'Александр', 'text' => 'Определённо лучшее место, куда я ходил! Всё на высшем уровне, прической остался доволен.'],
            ['name' => 'Олег', 'text' => 'Отличное место с приятным интерьером, музыкой и мастерами, которые сделают вам красивую и качественную стрижку.'],
            ['name' => 'Иван', 'text' => 'Когда дело не требует спешки, а индивидуального и тщательного подхода. Все супер!'],
            ['name' => 'Эдуард', 'text' => 'Отличный барбершоп! Хорошая атмосфера.'],
            ['name' => 'Максим', 'text' => 'Работаю возле GIDRA и часто ходю на стрижку. Мастера-профессионалы, всегда помогут советом по уходу.'],
            ['name' => 'Денис', 'text' => 'Стриженный в Курганском районе - GIDRA лучший вариант. Мастера знают свое дело!'],
            ['name' => 'Сергей', 'text' => 'Порекомендовал GIDRA всем друзьям. Качество и стиль - именно то, что нужно мужчине.'],
            ['name' => 'Павел', 'text' => 'Спасибо за творческий подход и внимание к деталям. Стрижка выглядит идеально!'],
            ['name' => 'Артём', 'text' => 'Люблю атмосферу, уют и профессионализм. Буду только в GIDRA!'],
        ];

        foreach ($reviewsData as $r) {
            Review::create(array_merge($r, ['date' => now(), 'approved' => true]));
        }

        
        Vacancy::create([
            'title' => 'Барбер',
            'description' => 'Команда GIDRA ищет новых сотрудников! Ищем мастеров...',
            'requirements' => "— Желание работать и зарабатывать;\n— Уважительное отношение к коллегам и гостям;\n— Готовность обучаться;\n— Отсутствие опозданий:);\n— Преданность профессии.",
            'conditions' => 'от 50 000 до 150 000 ₽ в месяц на руки'
        ]);
    }
}