import './bootstrap';
import Alpine from 'alpinejs';
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';

window.Alpine = Alpine;
Alpine.start();

gsap.registerPlugin(ScrollTrigger);

// reveal animation
document.querySelectorAll('.reveal').forEach((el) => {
    gsap.from(el, {
        opacity: 0,
        y: 80,
        duration: 1,
        scrollTrigger: {
            trigger: el,
            start: 'top 85%',
        }
    });
});

document.addEventListener('mousemove', (e) => {
    const glow = document.getElementById('cursor-glow');
    if (glow) {
        glow.style.left = e.clientX + 'px';
        glow.style.top = e.clientY + 'px';
    }
});

// БЕСКОНЕЧНАЯ КАРУСЕЛЬ ОТЗЫВОВ
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('reviewsTrack');
    if (!track) return;
    
    // Получаем оригинальные карточки
    const originalCards = Array.from(track.children);
    if (originalCards.length === 0) return;
    
    // Клонируем карточки для создания бесконечного эффекта (3 копии)
    const cloneCount = 3;
    for (let i = 0; i < cloneCount; i++) {
        originalCards.forEach(card => {
            const clone = card.cloneNode(true);
            track.appendChild(clone);
        });
    }
    
    // Получаем ширину одной карточки + gap
    const card = originalCards[0];
    const cardWidth = card.offsetWidth;
    const gap = 24; // 1.5rem в пикселях
    
    // Общая ширина одного набора оригинальных карточек
    const originalSetWidth = originalCards.length * (cardWidth + gap);
    
    // Настройки анимации
    let position = 0;
    const speed = 0.5; // пикселей за кадр (чем меньше, тем медленнее)
    let animationId = null;
    let isPaused = false;
    
    // Функция анимации
    function animate() {
        if (!isPaused) {
            position -= speed;
            
            // Сброс позиции когда дошли до конца копий
            // Должно быть сброшено до того, как мы увидим пустое место
            if (Math.abs(position) >= originalSetWidth) {
                position = 0;
            }
            
            track.style.transform = `translateX(${position}px)`;
        }
        
        animationId = requestAnimationFrame(animate);
    }
    
    // Запускаем анимацию
    animate();
    
    // Пауза при наведении на контейнер
    const container = document.querySelector('.reviews-container');
    if (container) {
        container.addEventListener('mouseenter', () => {
            isPaused = true;
        });
        
        container.addEventListener('mouseleave', () => {
            isPaused = false;
        });
    }
    
    // Опционально: пауза при наведении на любую карточку
    track.addEventListener('mouseenter', () => {
        isPaused = true;
    });
    
    track.addEventListener('mouseleave', () => {
        isPaused = false;
    });
    
    // Остановка анимации когда страница не видна (экономия ресурсов)
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            if (animationId) {
                cancelAnimationFrame(animationId);
                animationId = null;
            }
        } else {
            if (!animationId) {
                animate();
            }
        }
    });
});