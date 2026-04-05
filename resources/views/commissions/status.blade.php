<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Creative Portfolio') }} - Commission Status</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Anton&family=Bebas+Neue&family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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

            /* Navigation Bar */
            .nav-bar {
                background: #FDFDFC;
                padding: 1.5rem 3rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 2px solid #e0e0e0;
                position: sticky;
                top: 0;
                z-index: 100;
            }

            .nav-logo {
                font-family: 'Anton', sans-serif;
                font-size: 1.8rem;
                color: #0d328f;
                text-decoration: none;
                letter-spacing: 0.05em;
            }

            .nav-logo span {
                color: #1b1b18;
            }

            .nav-links {
                display: flex;
                gap: 2rem;
                align-items: center;
            }

            .nav-link {
                font-family: 'Instrument Sans', sans-serif;
                font-size: 1rem;
                color: #1b1b18;
                text-decoration: none;
                font-weight: 500;
                transition: color 0.3s ease;
                position: relative;
            }

            .nav-link:hover {
                color: #0d328f;
            }

            .nav-link::after {
                content: '';
                position: absolute;
                bottom: -5px;
                left: 0;
                width: 0;
                height: 2px;
                background: #0d328f;
                transition: width 0.3s ease;
            }

            .nav-link:hover::after {
                width: 100%;
            }

            .nav-link.active {
                color: #0d328f;
            }

            .nav-link.active::after {
                width: 100%;
            }

            /* Header */
            .status-header {
                text-align: center;
                padding: 4rem 2rem 3rem;
                background: #FDFDFC;
            }

            .status-header-title {
                font-family: 'Bebas Neue', sans-serif;
                font-size: 5rem;
                color: #2d3748;
                margin-bottom: 1rem;
                letter-spacing: 0.05em;
            }

            .status-header-subtitle {
                font-size: 1.2rem;
                color: #1b1b18;
                max-width: 600px;
                margin: 0 auto;
                line-height: 1.6;
            }

            /* Commission Status Container */
            .status-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 2rem 5rem;
            }

            /* Commission Card */
            .commission-card {
                background: #d8d8d8;
                border-radius: 1rem;
                padding: 2rem;
                margin-bottom: 2rem;
                transition: all 0.3s ease;
                border-left: 5px solid transparent;
            }

            .commission-card:hover {
                background: #e0e0e0;
                transform: translateY(-3px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            }

            .commission-card.status-pending {
                border-left-color: #eab308;
            }

            .commission-card.status-reviewing {
                border-left-color: #3b82f6;
            }

            .commission-card.status-accepted {
                border-left-color: #22c55e;
            }

            .commission-card.status-in_progress {
                border-left-color: #a855f7;
            }

            .commission-card.status-completed {
                border-left-color: #10b981;
            }

            .commission-card.status-cancelled {
                border-left-color: #6b7280;
            }

            .commission-card.status-rejected {
                border-left-color: #ef4444;
            }

            .commission-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                margin-bottom: 1.5rem;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .commission-title {
                font-family: 'Bebas Neue', sans-serif;
                font-size: 1.8rem;
                color: #1b1b18;
                letter-spacing: 0.05em;
            }

            .commission-date {
                font-size: 0.9rem;
                color: #6b7280;
            }

            /* Status Badge */
            .status-badge {
                display: inline-block;
                padding: 0.5rem 1.25rem;
                border-radius: 2rem;
                font-size: 0.9rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin-bottom: 1rem;
            }

            .status-badge.pending {
                background: #fef3c7;
                color: #92400e;
            }

            .status-badge.reviewing {
                background: #dbeafe;
                color: #1e40af;
            }

            .status-badge.accepted {
                background: #dcfce7;
                color: #166534;
            }

            .status-badge.in_progress {
                background: #f3e8ff;
                color: #7c3aed;
            }

            .status-badge.completed {
                background: #d1fae5;
                color: #065f46;
            }

            .status-badge.cancelled {
                background: #f3f4f6;
                color: #4b5563;
            }

            .status-badge.rejected {
                background: #fee2e2;
                color: #991b1b;
            }

            /* Commission Details */
            .commission-details {
                margin-top: 1.5rem;
                padding-top: 1.5rem;
                border-top: 2px solid rgba(0, 0, 0, 0.1);
            }

            .commission-detail-row {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .commission-detail {
                display: flex;
                flex-direction: column;
                gap: 0.25rem;
            }

            .commission-detail-label {
                font-size: 0.85rem;
                color: #6b7280;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .commission-detail-value {
                font-size: 1rem;
                color: #1b1b18;
                font-weight: 500;
            }

            .commission-description {
                font-size: 1rem;
                line-height: 1.6;
                color: #1b1b18;
                margin-top: 1rem;
                padding: 1rem;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 0.5rem;
            }

            /* Progress Timeline */
            .progress-timeline {
                margin-top: 2rem;
                padding: 1.5rem;
                background: rgba(255, 255, 255, 0.4);
                border-radius: 0.75rem;
            }

            .progress-timeline-title {
                font-family: 'Bebas Neue', sans-serif;
                font-size: 1.3rem;
                color: #0d328f;
                margin-bottom: 1rem;
            }

            .timeline-steps {
                display: flex;
                justify-content: space-between;
                position: relative;
                margin: 2rem 0;
            }

            .timeline-steps::before {
                content: '';
                position: absolute;
                top: 15px;
                left: 0;
                right: 0;
                height: 3px;
                background: #e0e0e0;
                z-index: 0;
            }

            .timeline-step {
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
                z-index: 1;
                flex: 1;
            }

            .timeline-step-dot {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                background: #e0e0e0;
                border: 3px solid #fff;
                margin-bottom: 0.5rem;
                transition: all 0.3s ease;
            }

            .timeline-step.completed .timeline-step-dot {
                background: #22c55e;
            }

            .timeline-step.current .timeline-step-dot {
                background: #3b82f6;
                box-shadow: 0 0 0 5px rgba(59, 130, 246, 0.3);
            }

            .timeline-step-label {
                font-size: 0.75rem;
                color: #6b7280;
                text-align: center;
            }

            .timeline-step.completed .timeline-step-label {
                color: #22c55e;
                font-weight: 600;
            }

            .timeline-step.current .timeline-step-label {
                color: #3b82f6;
                font-weight: 600;
            }

            /* Empty State */
            .empty-state {
                text-align: center;
                padding: 4rem 2rem;
                background: #d8d8d8;
                border-radius: 1rem;
                margin-top: 2rem;
            }

            .empty-state-icon {
                width: 80px;
                height: 80px;
                margin: 0 auto 1.5rem;
                background: #0d328f;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .empty-state-icon svg {
                width: 40px;
                height: 40px;
                fill: white;
            }

            .empty-state h3 {
                font-family: 'Bebas Neue', sans-serif;
                font-size: 2rem;
                color: #1b1b18;
                margin-bottom: 0.75rem;
            }

            .empty-state p {
                font-size: 1rem;
                color: #1b1b18;
                line-height: 1.6;
                margin-bottom: 1.5rem;
            }

            .empty-state-button {
                display: inline-block;
                background: #0d328f;
                color: white;
                padding: 1rem 2.5rem;
                border-radius: 2.5rem;
                font-family: 'Bebas Neue', sans-serif;
                font-size: 1.2rem;
                letter-spacing: 0.1em;
                text-decoration: none;
                transition: all 0.3s ease;
                box-shadow: 0 8px 25px rgba(13, 50, 143, 0.4);
            }

            .empty-state-button:hover {
                background: #0a256b;
                transform: translateY(-3px);
                box-shadow: 0 12px 35px rgba(13, 50, 143, 0.5);
            }

            /* Back to Home Button */
            .back-home-btn {
                position: fixed;
                bottom: 2rem;
                right: 2rem;
                background: #0d328f;
                color: white;
                padding: 1rem 2rem;
                border-radius: 2.5rem;
                font-family: 'Bebas Neue', sans-serif;
                font-size: 1rem;
                letter-spacing: 0.1em;
                text-decoration: none;
                transition: all 0.3s ease;
                box-shadow: 0 8px 25px rgba(13, 50, 143, 0.4);
                z-index: 99;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .back-home-btn:hover {
                background: #0a256b;
                transform: translateY(-3px);
                box-shadow: 0 12px 35px rgba(13, 50, 143, 0.5);
            }

            .back-home-btn svg {
                width: 20px;
                height: 20px;
                fill: white;
            }

            /* Responsive */
            @media (max-width: 1024px) {
                .status-header-title {
                    font-size: 4rem;
                }

                .nav-bar {
                    padding: 1.5rem 2rem;
                }
            }

            @media (max-width: 768px) {
                .status-header-title {
                    font-size: 3.5rem;
                }

                .status-header-subtitle {
                    font-size: 1rem;
                }

                .nav-bar {
                    padding: 1rem 1.5rem;
                    flex-direction: column;
                    gap: 1rem;
                }

                .nav-links {
                    gap: 1.5rem;
                    flex-wrap: wrap;
                    justify-content: center;
                }

                .commission-header {
                    flex-direction: column;
                }

                .commission-detail-row {
                    grid-template-columns: 1fr;
                }

                .timeline-steps {
                    flex-direction: column;
                    gap: 1.5rem;
                }

                .timeline-steps::before {
                    display: none;
                }

                .back-home-btn {
                    bottom: 1.5rem;
                    right: 1.5rem;
                    padding: 0.8rem 1.5rem;
                    font-size: 0.9rem;
                }
            }

            @media (max-width: 480px) {
                .status-header {
                    padding: 3rem 1.5rem 2rem;
                }

                .status-header-title {
                    font-size: 2.5rem;
                }

                .status-container {
                    padding: 0 1.5rem 3rem;
                }

                .commission-card {
                    padding: 1.5rem;
                }

                .commission-title {
                    font-size: 1.5rem;
                }

                .nav-logo {
                    font-size: 1.5rem;
                }

                .nav-link {
                    font-size: 0.9rem;
                }
            }
        </style>
    </head>
    <body>
        <!-- Navigation Bar -->
        <nav class="nav-bar">
            <a href="{{ route('home') }}" class="nav-logo">
                <span>CREATIVE</span> PORTFOLIO
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('commissions.create') }}" class="nav-link">New Commission</a>
                <a href="{{ route('commissions.status') }}" class="nav-link active">My Commissions</a>
            </div>
        </nav>

        <!-- Header -->
        <section class="status-header">
            <h1 class="status-header-title">My Commissions</h1>
            <p class="status-header-subtitle">
                Track the status of your commission orders. We'll keep you updated on the progress.
            </p>
        </section>

        <!-- Commission Status Container -->
        <div class="status-container">
            @if($commissions->isEmpty())
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                    </div>
                    <h3>No Commissions Yet</h3>
                    <p>You haven't submitted any commission orders yet. Create your first commission to get started!</p>
                    <a href="{{ route('commissions.create') }}" class="empty-state-button">CREATE COMMISSION</a>
                </div>
            @else
                @foreach($commissions as $commission)
                    <div class="commission-card status-{{ str_replace('_', '-', $commission->status) }}">
                        <div class="commission-header">
                            <div>
                                <h2 class="commission-title">Commission #{{ $commission->id }}</h2>
                                <p class="commission-date">
                                    Submitted: {{ $commission->created_at->format('d M Y, H:i') }}
                                    @if($commission->deadline)
                                        | Deadline: {{ $commission->deadline->format('d M Y') }}
                                    @endif
                                </p>
                            </div>
                            <span class="status-badge {{ $commission->status }}">
                                {{ ucfirst(str_replace('_', ' ', $commission->status)) }}
                            </span>
                        </div>

                        <div class="commission-details">
                            @if($commission->character_type)
                            <div class="commission-detail-row">
                                <div class="commission-detail">
                                    <span class="commission-detail-label">Character Type</span>
                                    <span class="commission-detail-value">{{ ucfirst(str_replace('_', ' ', $commission->character_type)) }}</span>
                                </div>
                                @if($commission->character_count)
                                <div class="commission-detail">
                                    <span class="commission-detail-label">Character Count</span>
                                    <span class="commission-detail-value">{{ $commission->character_count }}</span>
                                </div>
                                @endif
                                @if($commission->budget)
                                <div class="commission-detail">
                                    <span class="commission-detail-label">Budget</span>
                                    <span class="commission-detail-value">Rp {{ number_format($commission->budget, 0, ',', '.') }}</span>
                                </div>
                                @endif
                            </div>
                            @endif

                            @if($commission->description)
                            <div class="commission-description">
                                {{ $commission->description }}
                            </div>
                            @endif

                            @if($commission->admin_notes)
                            <div class="commission-detail" style="margin-top: 1rem;">
                                <span class="commission-detail-label">Admin Notes</span>
                                <div class="commission-detail-value" style="margin-top: 0.5rem; padding: 1rem; background: rgba(255, 255, 255, 0.5); border-radius: 0.5rem;">
                                    {{ $commission->admin_notes }}
                                </div>
                            </div>
                            @endif

                            <!-- Progress Timeline -->
                            <div class="progress-timeline">
                                <h3 class="progress-timeline-title">Progress Timeline</h3>
                                <div class="timeline-steps">
                                    @php
                                        $statuses = ['pending', 'reviewing', 'accepted', 'in_progress', 'completed'];
                                        $currentStatusIndex = array_search($commission->status, $statuses);
                                        if ($currentStatusIndex === false) {
                                            $currentStatusIndex = count($statuses);
                                        }
                                    @endphp
                                    
                                    @foreach($statuses as $index => $status)
                                        <div class="timeline-step 
                                            @if($index < $currentStatusIndex) completed 
                                            @elseif($index == $currentStatusIndex) current 
                                            @endif">
                                            <div class="timeline-step-dot"></div>
                                            <span class="timeline-step-label">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Back to Home Button -->
        <a href="{{ route('home') }}" class="back-home-btn">
            <svg viewBox="0 0 24 24">
                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
            </svg>
            Back to Home
        </a>
    </body>
</html>
