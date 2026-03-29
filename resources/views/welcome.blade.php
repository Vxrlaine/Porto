<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Creative Portfolio') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Anton&family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Base styles */
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }

                body {
                    font-family: 'Instrument Sans', sans-serif;
                    background: #FDFDFC;
                    color: #1b1b18;
                    overflow-x: hidden;
                }

                /* Header Section */
                .header {
                    text-align: center;
                    padding: 2rem 0 0;
                    position: relative;
                    background: #FDFDFC;
                    overflow: visible;
                    margin-bottom: -180px;
                    min-height: 450px;
                }

                .header-commission {
                    font-family: 'Anton', sans-serif;
                    font-size: 1.3rem;
                    letter-spacing: 0.4em;
                    text-transform: uppercase;
                    margin-bottom: 0.75rem;
                    color: #1b1b18;
                    font-weight: 400;
                }

                .header-title-wrapper {
                    position: relative;
                    display: inline-block;
                    padding-top: 0.75rem;
                }

                .header-creative {
                    font-family: 'Dancing Script', cursive;
                    font-size: 3.5rem;
                    color: #1b1b18;
                    position: absolute;
                    top: -1.5rem;
                    left: 1.5rem;
                    z-index: 5;
                }

                .header-portfolio {
                    font-family: 'Anton', sans-serif;
                    font-size: 10rem;
                    color: #0d328f;
                    letter-spacing: 0.05em;
                    position: relative;
                    display: inline-block;
                    line-height: 1;
                }

                .header-portfolio .asterisk {
                    position: absolute;
                    top: -0.7rem;
                    right: 0.7rem;
                    font-size: 5.5rem;
                    color: #1b1b18;
                    line-height: 1;
                    font-weight: bold;
                }

                .header-body-image {
                    position: absolute;
                    top: 43.5%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    height: 600px;
                    width: auto;
                    z-index: 10;
                    clip-path: inset(0 0 30% 0);
                }

                .header-note {
                    position: absolute;
                    top: 2rem;
                    right: 2%;
                    width: 220px;
                    transform: rotate(15deg);
                    z-index: 10;
                }

                .header-note img {
                    width: 100%;
                    height: auto;
                    opacity: 0.85;
                }

                /* About Section */
                .about-section {
                    background: #d8d8d8;
                    padding: 10rem 5% 4rem;
                    position: relative;
                    z-index: 5;
                }

                .about-title {
                    font-family: 'Dancing Script', cursive;
                    font-size: 5.5rem;
                    color: #2d3748;
                    text-align: left;
                    margin-bottom: 2rem;
                    margin-left: 0;
                }

                .about-grid {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 4rem;
                    max-width: 1200px;
                    margin: 0 auto;
                    align-items: start;
                }

                .about-content {
                    padding: 0;
                }

                .about-title {
                    font-family: 'Dancing Script', cursive;
                    font-size: 5.5rem;
                    color: #2d3748;
                    text-align: left;
                    margin-bottom: 1.5rem;
                    margin-left: 0;
                    line-height: 1.2;
                }

                .about-text {
                    font-size: 1.1rem;
                    line-height: 1.8;
                    color: #1b1b18;
                    text-align: left;
                    font-family: 'Instrument Sans', sans-serif;
                    margin: 0;
                }

                .about-right {
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 1rem;
                }

                .about-image-wrapper {
                    width: 100%;
                    position: relative;
                }

                .about-image-placeholder {
                    width: 100%;
                    height: 280px;
                    background: #000000;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #fff;
                    font-size: 1rem;
                    border-radius: 0.5rem;
                    flex-shrink: 0;
                }

                .about-image {
                    width: 100%;
                    height: 280px;
                    object-fit: contain;
                    border-radius: 0.5rem;
                    display: block;
                }

                .about-illustrator {
                    font-family: 'Instrument Sans', sans-serif;
                    font-size: 0.95rem;
                    line-height: 1.8;
                    color: #1b1b18;
                    text-align: left;
                    margin: 0;
                    padding: 0.5rem 0;
                    width: 100%;
                }

                /* My Design Section */
                .design-section {
                    padding: 5rem 2rem 6rem;
                    background: #FDFDFC;
                    text-align: center;
                }

                .design-title {
                    font-family: 'Dancing Script', cursive;
                    font-size: 6.5rem;
                    color: #2d3748;
                    margin-bottom: 3rem;
                }

                /* Carousel Container */
                .carousel-container {
                    position: relative;
                    width: 100%;
                    max-width: 1000px;
                    height: 580px;
                    margin: 0 auto;
                    perspective: 1200px;
                }

                .carousel {
                    position: relative;
                    width: 100%;
                    height: 100%;
                    transform-style: preserve-3d;
                }

                .carousel-card {
                    position: absolute;
                    width: 320px;
                    height: 440px;
                    left: 50%;
                    top: 50%;
                    transform-origin: center center;
                    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
                    border-radius: 1rem;
                    overflow: hidden;
                    cursor: pointer;
                    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                }

                .carousel-card-image {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    background: #e0e0e0;
                }

                .carousel-card-placeholder {
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(135deg, #e0e0e0 0%, #d0d0d0 100%);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #888;
                    font-size: 1rem;
                }

                /* Card positions in fan layout */
                .carousel-card.position-2 {
                    transform: translate(-50%, -50%) translateX(-300px) rotateY(30deg) scale(0.8);
                    z-index: 1;
                    opacity: 0.6;
                }

                .carousel-card.position-1 {
                    transform: translate(-50%, -50%) translateX(-150px) rotateY(20deg) scale(0.9);
                    z-index: 2;
                    opacity: 0.8;
                }

                .carousel-card.position-0 {
                    transform: translate(-50%, -50%) translateX(0) rotateY(0deg) scale(1);
                    z-index: 3;
                    opacity: 1;
                    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                }

                .carousel-card.position1 {
                    transform: translate(-50%, -50%) translateX(150px) rotateY(-20deg) scale(0.9);
                    z-index: 2;
                    opacity: 0.8;
                }

                .carousel-card.position2 {
                    transform: translate(-50%, -50%) translateX(300px) rotateY(-30deg) scale(0.8);
                    z-index: 1;
                    opacity: 0.6;
                }

                /* Navigation Arrows on cards */
                .carousel-nav {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    width: 48px;
                    height: 48px;
                    background: white;
                    border: 2px solid #1b1b18;
                    border-radius: 8px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 20;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
                }

                .carousel-nav:hover:not(:disabled) {
                    background: #f5f5f5;
                    transform: translateY(-50%) scale(1.1);
                }

                .carousel-nav:disabled {
                    opacity: 0.4;
                    cursor: not-allowed;
                }

                .carousel-nav-left {
                    left: 120px;
                }

                .carousel-nav-right {
                    right: 120px;
                }

                .carousel-nav svg {
                    width: 24px;
                    height: 24px;
                    fill: #1b1b18;
                }

                /* Project Button */
                .project-button {
                    position: absolute;
                    bottom: 30px;
                    left: 50%;
                    transform: translateX(-50%);
                    background: #0d328f;
                    color: white;
                    padding: 1.25rem 3.5rem;
                    border-radius: 2.5rem;
                    font-family: 'Anton', sans-serif;
                    font-size: 1.4rem;
                    letter-spacing: 0.15em;
                    text-transform: uppercase;
                    border: none;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    z-index: 20;
                    box-shadow: 0 8px 25px rgba(13, 50, 143, 0.4);
                }

                .project-button:hover {
                    background: #0a256b;
                    transform: translateX(-50%) translateY(-3px);
                    box-shadow: 0 12px 35px rgba(13, 50, 143, 0.5);
                }

                /* My Experience Section */
                .experience-section {
                    background: #d8d8d8;
                    padding: 5rem 5% 4rem;
                }

                .experience-title {
                    font-family: 'Dancing Script', cursive;
                    font-size: 6.5rem;
                    color: #2d3748;
                    text-align: center;
                    margin-bottom: 4rem;
                }

                .experience-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 2rem;
                    max-width: 1200px;
                    margin: 0 auto;
                    justify-content: center;
                    justify-items: center;
                }

                .experience-item {
                    display: flex;
                    flex-direction: column;
                    gap: 1rem;
                    align-items: center;
                    text-align: center;
                    padding: 2rem 1.5rem;
                    background: rgba(255, 255, 255, 0.2);
                    border-radius: 1rem;
                    transition: all 0.3s ease;
                    max-width: 300px;
                }

                .experience-item:hover {
                    background: rgba(255, 255, 255, 0.4);
                    transform: translateY(-5px);
                }

                .experience-icon {
                    width: 60px;
                    height: 60px;
                    flex-shrink: 0;
                    background: #0d328f;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .experience-icon svg {
                    width: 32px;
                    height: 32px;
                    fill: white;
                }

                .experience-content {
                    text-align: center;
                }

                .experience-content h3 {
                    font-family: 'Anton', sans-serif;
                    font-size: 1.5rem;
                    letter-spacing: 0.05em;
                    text-transform: uppercase;
                    margin-bottom: 0.75rem;
                    color: #1b1b18;
                }

                .experience-content p {
                    font-size: 0.95rem;
                    line-height: 1.6;
                    color: #1b1b18;
                }

                /* Fullscreen Modal */
                .fullscreen-modal {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.95);
                    z-index: 9999;
                    display: none;
                    align-items: center;
                    justify-content: center;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }

                .fullscreen-modal.active {
                    display: flex;
                    opacity: 1;
                }

                .modal-close {
                    position: absolute;
                    top: 20px;
                    right: 20px;
                    width: 50px;
                    height: 50px;
                    background: rgba(255, 255, 255, 0.1);
                    border: 2px solid rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 10000;
                    transition: all 0.3s ease;
                }

                .modal-close:hover {
                    background: rgba(255, 255, 255, 0.2);
                    border-color: rgba(255, 255, 255, 0.6);
                    transform: rotate(90deg);
                }

                .modal-close svg {
                    width: 28px;
                    height: 28px;
                    fill: white;
                }

                .modal-nav {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    width: 60px;
                    height: 60px;
                    background: rgba(255, 255, 255, 0.1);
                    border: 2px solid rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 10000;
                    transition: all 0.3s ease;
                }

                .modal-nav:hover {
                    background: rgba(255, 255, 255, 0.2);
                    border-color: rgba(255, 255, 255, 0.6);
                    transform: translateY(-50%) scale(1.1);
                }

                .modal-nav svg {
                    width: 32px;
                    height: 32px;
                    fill: white;
                }

                .modal-prev {
                    left: 30px;
                }

                .modal-next {
                    right: 30px;
                }

                .modal-content {
                    max-width: 90%;
                    max-height: 85vh;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }

                .modal-content img {
                    max-width: 100%;
                    max-height: 75vh;
                    object-fit: contain;
                    border-radius: 8px;
                    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
                }

                .modal-caption {
                    text-align: center;
                    color: white;
                    margin-top: 1.5rem;
                    max-width: 600px;
                }

                .modal-title {
                    font-family: 'Anton', sans-serif;
                    font-size: 2rem;
                    letter-spacing: 0.05em;
                    margin-bottom: 0.5rem;
                    color: #0d328f;
                }

                .modal-description {
                    font-size: 1rem;
                    line-height: 1.6;
                    color: rgba(255, 255, 255, 0.8);
                }

                .modal-counter {
                    position: absolute;
                    bottom: 30px;
                    left: 50%;
                    transform: translateX(-50%);
                    color: white;
                    font-family: 'Anton', sans-serif;
                    font-size: 1.2rem;
                    letter-spacing: 0.1em;
                }

                /* Responsive Modal */
                @media (max-width: 768px) {
                    .modal-close {
                        top: 15px;
                        right: 15px;
                        width: 44px;
                        height: 44px;
                    }
                    .modal-close svg {
                        width: 24px;
                        height: 24px;
                    }
                    .modal-nav {
                        width: 50px;
                        height: 50px;
                    }
                    .modal-nav svg {
                        width: 28px;
                        height: 28px;
                    }
                    .modal-prev {
                        left: 15px;
                    }
                    .modal-next {
                        right: 15px;
                    }
                    .modal-content {
                        max-width: 95%;
                    }
                    .modal-title {
                        font-size: 1.5rem;
                    }
                    .modal-description {
                        font-size: 0.9rem;
                    }
                }

                /* Responsive */
                @media (max-width: 1024px) {
                    .header {
                        margin-bottom: -120px;
                        min-height: 400px;
                    }
                    .header-commission {
                        font-size: 1.1rem;
                    }
                    .header-creative {
                        font-size: 2.8rem;
                        left: 1rem;
                    }
                    .header-portfolio {
                        font-size: 8rem;
                    }
                    .header-portfolio .asterisk {
                        font-size: 4rem;
                    }
                    .header-body-image {
                        height: 500px;
                        top: 30%;
                    }
                    .header-note {
                        width: 180px;
                        right: 1%;
                    }
                    .about-section {
                        padding: 8rem 3% 3rem;
                    }
                    .about-title {
                        font-size: 4.5rem;
                    }
                    .about-grid {
                        gap: 3rem;
                    }
                    .about-image-placeholder {
                        height: 240px;
                    }
                    .design-title {
                        font-size: 5.5rem;
                    }
                    .carousel-container {
                        max-width: 850px;
                        height: 520px;
                    }
                    .carousel-card {
                        width: 280px;
                        height: 380px;
                    }
                    .carousel-card.position-2 {
                        transform: translate(-50%, -50%) translateX(-260px) rotateY(32deg) scale(0.8);
                    }
                    .carousel-card.position-1 {
                        transform: translate(-50%, -50%) translateX(-130px) rotateY(22deg) scale(0.9);
                    }
                    .carousel-card.position1 {
                        transform: translate(-50%, -50%) translateX(130px) rotateY(-22deg) scale(0.9);
                    }
                    .carousel-card.position2 {
                        transform: translate(-50%, -50%) translateX(260px) rotateY(-32deg) scale(0.8);
                    }
                    .carousel-nav-left {
                        left: 100px;
                    }
                    .carousel-nav-right {
                        right: 100px;
                    }
                    .experience-title {
                        font-size: 5.5rem;
                    }
                }

                @media (max-width: 768px) {
                    .header {
                        padding: 1.5rem 0 0;
                        margin-bottom: -100px;
                        min-height: 320px;
                    }
                    .header-commission {
                        font-size: 0.9rem;
                        letter-spacing: 0.3em;
                    }
                    .header-creative {
                        font-size: 2rem;
                        top: -1rem;
                        left: 0.8rem;
                    }
                    .header-portfolio {
                        font-size: 5rem;
                    }
                    .header-portfolio .asterisk {
                        font-size: 2.5rem;
                        top: -0.4rem;
                        right: 0.2rem;
                    }
                    .header-body-image {
                        height: 350px;
                        top: 35%;
                        clip-path: inset(0 0 35% 0);
                    }
                    .header-note {
                        display: none;
                    }
                    .about-section {
                        padding: 7rem 2rem 2.5rem;
                    }
                    .about-grid {
                        grid-template-columns: 1fr;
                        gap: 2.5rem;
                    }
                    .about-content {
                        text-align: center;
                    }
                    .about-title {
                        font-size: 4rem;
                        text-align: center;
                        margin-left: 0;
                    }
                    .about-text {
                        text-align: center;
                    }
                    .about-right {
                        align-items: center;
                    }
                    .about-image-wrapper {
                        width: 100%;
                        max-width: 380px;
                    }
                    .about-image-placeholder {
                        max-width: 380px;
                        height: 220px;
                    }
                    .about-illustrator {
                        text-align: center;
                    }
                    .design-title,
                    .experience-title {
                        font-size: 4.5rem;
                    }
                    .carousel-container {
                        height: 460px;
                        max-width: 100%;
                    }
                    .carousel-card {
                        width: 240px;
                        height: 320px;
                    }
                    .carousel-card.position-2 {
                        transform: translate(-50%, -50%) translateX(-200px) rotateY(30deg) scale(0.75);
                    }
                    .carousel-card.position-1 {
                        transform: translate(-50%, -50%) translateX(-100px) rotateY(22deg) scale(0.85);
                    }
                    .carousel-card.position1 {
                        transform: translate(-50%, -50%) translateX(100px) rotateY(-22deg) scale(0.85);
                    }
                    .carousel-card.position2 {
                        transform: translate(-50%, -50%) translateX(200px) rotateY(-30deg) scale(0.75);
                    }
                    .carousel-nav {
                        width: 44px;
                        height: 44px;
                    }
                    .carousel-nav-left {
                        left: 60px;
                    }
                    .carousel-nav-right {
                        right: 60px;
                    }
                    .experience-grid {
                        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                        gap: 1.5rem;
                        justify-items: center;
                    }
                    .experience-item {
                        padding: 1.5rem 1rem;
                    }
                    .experience-icon {
                        width: 50px;
                        height: 50px;
                    }
                    .experience-icon svg {
                        width: 28px;
                        height: 28px;
                    }
                    .experience-content h3 {
                        font-size: 1.3rem;
                    }
                    .experience-content p {
                        font-size: 0.9rem;
                    }
                }

                @media (max-width: 480px) {
                    .header {
                        min-height: 260px;
                        margin-bottom: -50px;
                    }
                    .header-commission {
                        font-size: 0.75rem;
                    }
                    .header-creative {
                        font-size: 1.5rem;
                        top: -0.8rem;
                    }
                    .header-portfolio {
                        font-size: 3.5rem;
                    }
                    .header-portfolio .asterisk {
                        font-size: 2rem;
                    }
                    .header-body-image {
                        height: 260px;
                        top: 40%;
                    }
                    .about-section {
                        padding: 6rem 1.5rem 2rem;
                    }
                    .about-title {
                        font-size: 3rem;
                    }
                    .about-text {
                        font-size: 0.9rem;
                    }
                    .about-image-placeholder {
                        height: 180px;
                    }
                    .about-illustrator {
                        font-size: 3rem;
                    }
                    .design-title {
                        font-size: 3.5rem;
                    }
                    .carousel-container {
                        height: 400px;
                    }
                    .carousel-card {
                        width: 200px;
                        height: 280px;
                    }
                    .carousel-card.position-2 {
                        transform: translate(-50%, -50%) translateX(-160px) rotateY(28deg) scale(0.7);
                    }
                    .carousel-card.position-1 {
                        transform: translate(-50%, -50%) translateX(-80px) rotateY(20deg) scale(0.8);
                    }
                    .carousel-card.position1 {
                        transform: translate(-50%, -50%) translateX(80px) rotateY(-20deg) scale(0.8);
                    }
                    .carousel-card.position2 {
                        transform: translate(-50%, -50%) translateX(160px) rotateY(-28deg) scale(0.7);
                    }
                    .project-button {
                        padding: 1rem 2rem;
                        font-size: 1rem;
                    }
                    .experience-title {
                        font-size: 3.5rem;
                    }
                    .experience-grid {
                        grid-template-columns: 1fr;
                        gap: 1rem;
                        justify-items: center;
                    }
                    .experience-item {
                        padding: 1.5rem 1rem;
                    }
                    .experience-icon {
                        width: 50px;
                        height: 50px;
                    }
                    .experience-icon svg {
                        width: 28px;
                        height: 28px;
                    }
                    .experience-content h3 {
                        font-size: 1.2rem;
                    }
                    .experience-content p {
                        font-size: 0.85rem;
                    }
                }

                /* Zoom handling - when viewport becomes small due to zoom */
                @media (max-width: 1200px) and (min-resolution: 120dpi) {
                    .header {
                        margin-bottom: -10%;
                    }
                    .header-body-image {
                        height: 55%;
                        bottom: -3%;
                        top: auto;
                    }
                    .about-section {
                        padding-top: 15%;
                    }
                }

                @media (max-width: 900px) and (min-resolution: 150dpi) {
                    .header {
                        margin-bottom: -8%;
                    }
                    .header-body-image {
                        height: 50%;
                        bottom: -5%;
                        top: auto;
                    }
                    .about-section {
                        padding-top: 18%;
                    }
                }
            </style>
        @endif
    </head>
    <body>
        <!-- Header Section -->
        <header class="header">
            <div class="header-commission">COMISSION</div>
            <div class="header-title-wrapper">
                <span class="header-creative">Creative</span>
                <span class="header-portfolio">
                    PORTFOLIO
                    <span class="asterisk">*</span>
                </span>
                <img src="{{ asset('Body.png') }}" alt="Body" class="header-body-image" onerror="this.style.display='none'">
            </div>
            <div class="header-note">
                <img src="{{ asset('images/note-placeholder.png') }}" alt="Catatan" onerror="this.style.display='none'">
            </div>
        </header>

        <!-- About Section -->
        <section class="about-section">
            <div class="about-grid">
                <div class="about-content">
                    <h2 class="about-title">About me</h2>
                    <p class="about-text">
                        Hi, I'm a character illustrator passionate about bringing unique characters to life. From expressive anime-style designs to detailed character concepts, I create visuals that tell stories and capture personality. My work focuses on emotion, style, and imagination turning ideas into memorable characters. Let's create something amazing together!
                    </p>
                </div>
                <div class="about-right">
                    <img src="{{ asset('storage/images/whale.png') }}" 
                         alt="About Illustration" 
                         class="about-image"
                         onerror="this.style.display='none'">
                </div>
            </div>
        </section>

        <!-- My Design Section with Carousel -->
        <section class="design-section">
            <h2 class="design-title">My design</h2>
            
            <div class="carousel-container">
                <!-- Navigation Arrows -->
                <button class="carousel-nav carousel-nav-left" id="prevBtn" aria-label="Previous">
                    <svg viewBox="0 0 24 24">
                        <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                    </svg>
                </button>
                <button class="carousel-nav carousel-nav-right" id="nextBtn" aria-label="Next">
                    <svg viewBox="0 0 24 24">
                        <path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z"/>
                    </svg>
                </button>

                <!-- Carousel Cards -->
                <div class="carousel" id="carousel">
                    <!-- Cards will be dynamically generated by JavaScript -->
                </div>

                <!-- Project Button -->
                <button class="project-button" id="projectBtn">PROJECT</button>
            </div>
        </section>

        <!-- Fullscreen Modal -->
        <div class="fullscreen-modal" id="fullscreenModal">
            <button class="modal-close" id="modalClose" aria-label="Close">
                <svg viewBox="0 0 24 24">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </button>
            <button class="modal-nav modal-prev" id="modalPrev" aria-label="Previous">
                <svg viewBox="0 0 24 24">
                    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                </svg>
            </button>
            <button class="modal-nav modal-next" id="modalNext" aria-label="Next">
                <svg viewBox="0 0 24 24">
                    <path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z"/>
                </svg>
            </button>
            <div class="modal-content">
                <img src="" alt="Project" id="modalImage">
                <div class="modal-caption" id="modalCaption">
                    <h3 class="modal-title"></h3>
                    <p class="modal-description"></p>
                </div>
            </div>
            <div class="modal-counter" id="modalCounter"></div>
        </div>

        <!-- My Experience Section -->
        <section class="experience-section">
            <h2 class="experience-title">My experience</h2>
            <div class="experience-grid">
                @foreach(config('portfolio.experiences', []) as $experience)
                <div class="experience-item">
                    <div class="experience-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <div class="experience-content">
                        <h3>{{ $experience['title'] }}</h3>
                        <p>{{ $experience['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <script>
            // Carousel data - loaded from database
            const carouselImages = [
                @foreach($portfolioImages as $image)
                    {
                        src: '{{ asset($image->image_path) }}',
                        alt: '{{ $image->title ?? "Project" }}',
                        title: '{{ $image->title ?? "" }}',
                        description: '{{ $image->description ?? "" }}'
                    },
                @endforeach
            ];

            let currentIndex = Math.floor(carouselImages.length / 2); // Start with center card

            function getPositionClass(index, current) {
                const diff = index - current;
                if (diff < -2) return 'position-2';
                if (diff === -2) return 'position-2';
                if (diff === -1) return 'position-1';
                if (diff === 0) return 'position-0';
                if (diff === 1) return 'position1';
                if (diff === 2) return 'position2';
                return 'position2';
            }

            function updateButtonStates() {
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                
                // Disable prev button at first image
                prevBtn.disabled = currentIndex === 0;
                
                // Disable next button at last image
                nextBtn.disabled = currentIndex === carouselImages.length - 1;
            }

            function renderCarousel() {
                const carousel = document.getElementById('carousel');
                carousel.innerHTML = '';

                carouselImages.forEach((image, index) => {
                    const card = document.createElement('div');
                    card.className = `carousel-card ${getPositionClass(index, currentIndex)}`;

                    // Image container with placeholder support
                    if (image.src) {
                        card.innerHTML = `
                            <img
                                src="${image.src}"
                                alt="${image.alt}"
                                class="carousel-card-image"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >
                            <div class="carousel-card-placeholder" style="display:none;">
                                <span>No Image</span>
                            </div>
                        `;
                    } else {
                        card.innerHTML = `
                            <div class="carousel-card-placeholder">
                                <span>Placeholder Image</span>
                            </div>
                        `;
                    }

                    // Click to bring to center or open modal if already center
                    card.addEventListener('click', (e) => {
                        e.stopPropagation();
                        if (index === currentIndex) {
                            // Already in center, open modal
                            openModal(index);
                        } else {
                            currentIndex = index;
                            renderCarousel();
                        }
                    });

                    carousel.appendChild(card);
                });

                // Update button states after rendering
                updateButtonStates();
            }

            function nextSlide() {
                if (currentIndex < carouselImages.length - 1) {
                    currentIndex++;
                    renderCarousel();
                }
            }

            function prevSlide() {
                if (currentIndex > 0) {
                    currentIndex--;
                    renderCarousel();
                }
            }

            // Event listeners
            document.getElementById('nextBtn').addEventListener('click', nextSlide);
            document.getElementById('prevBtn').addEventListener('click', prevSlide);

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowRight') nextSlide();
                if (e.key === 'ArrowLeft') prevSlide();
            });

            // Initialize carousel
            renderCarousel();

            // ========== FULLSCREEN MODAL ==========
            const fullscreenModal = document.getElementById('fullscreenModal');
            const modalImage = document.getElementById('modalImage');
            const modalTitle = document.querySelector('.modal-title');
            const modalDescription = document.querySelector('.modal-description');
            const modalCounter = document.getElementById('modalCounter');
            const modalClose = document.getElementById('modalClose');
            const modalPrev = document.getElementById('modalPrev');
            const modalNext = document.getElementById('modalNext');
            const projectBtn = document.getElementById('projectBtn');
            let modalCurrentIndex = 0;

            // Open modal with project button (show first image)
            if (projectBtn && carouselImages.length > 0) {
                projectBtn.addEventListener('click', () => {
                    modalCurrentIndex = 0;
                    openModal(modalCurrentIndex);
                });
            }

            // Open modal function
            function openModal(index) {
                if (carouselImages.length === 0) return;
                
                modalCurrentIndex = index;
                updateModalContent();
                fullscreenModal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            // Close modal function
            function closeModal() {
                fullscreenModal.classList.remove('active');
                document.body.style.overflow = '';
            }

            // Update modal content
            function updateModalContent() {
                const image = carouselImages[modalCurrentIndex];
                modalImage.src = image.src;
                modalImage.alt = image.alt;
                modalTitle.textContent = image.title || 'Project';
                modalDescription.textContent = image.description || '';
                modalCounter.textContent = `${modalCurrentIndex + 1} / ${carouselImages.length}`;
                
                // Disable/enable navigation buttons
                modalPrev.style.opacity = modalCurrentIndex === 0 ? '0.3' : '1';
                modalNext.style.opacity = modalCurrentIndex === carouselImages.length - 1 ? '0.3' : '1';
            }

            // Next image in modal
            function modalNextImage() {
                if (modalCurrentIndex < carouselImages.length - 1) {
                    modalCurrentIndex++;
                    updateModalContent();
                }
            }

            // Previous image in modal
            function modalPrevImage() {
                if (modalCurrentIndex > 0) {
                    modalCurrentIndex--;
                    updateModalContent();
                }
            }

            // Event listeners for modal
            if (modalClose) {
                modalClose.addEventListener('click', closeModal);
            }

            if (modalPrev) {
                modalPrev.addEventListener('click', modalPrevImage);
            }

            if (modalNext) {
                modalNext.addEventListener('click', modalNextImage);
            }

            // Close on background click
            fullscreenModal.addEventListener('click', (e) => {
                if (e.target === fullscreenModal) {
                    closeModal();
                }
            });

            // Keyboard navigation for modal
            document.addEventListener('keydown', (e) => {
                if (!fullscreenModal.classList.contains('active')) return;
                
                if (e.key === 'Escape') closeModal();
                if (e.key === 'ArrowRight') modalNextImage();
                if (e.key === 'ArrowLeft') modalPrevImage();
            });

            // Close modal when clicking on carousel (outside modal)
            document.addEventListener('click', (e) => {
                if (fullscreenModal.classList.contains('active') && 
                    !e.target.closest('.fullscreen-modal') &&
                    !e.target.closest('.carousel-container')) {
                    closeModal();
                }
            });
        </script>
    </body>
</html>