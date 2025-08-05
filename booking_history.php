<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketist - My Bookings</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="css/booking_history.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <h1 class="logo animate__animated animate__fadeIn">Ticketist</h1>
            <nav>
                <ul>
                    <li><a href="index.html" class="animate__animated animate__fadeIn animate__delay-1s"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="events.html" class="animate__animated animate__fadeIn animate__delay-1s"><i class="fas fa-calendar-alt"></i> Events</a></li>
                    <li class="active"><a href="booking_history.html" class="animate__animated animate__fadeIn animate__delay-1s"><i class="fas fa-ticket-alt"></i> My Bookings</a></li>
                    <li><a href="profile.html" class="animate__animated animate__fadeIn animate__delay-1s"><i class="fas fa-user"></i> Profile</a></li>
                    <li><a href="#" id="logout" class="animate__animated animate__fadeIn animate__delay-1s"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="booking-history">
            <h2 class="animate__animated animate__fadeIn animate__delay-2s">My Bookings</h2>
            <div class="filter-options animate__animated animate__fadeIn animate__delay-2s">
                <button class="filter-btn active" data-filter="all"><i class="fas fa-list"></i> All</button>
                <button class="filter-btn" data-filter="upcoming"><i class="fas fa-clock"></i> Upcoming</button>
                <button class="filter-btn" data-filter="past"><i class="fas fa-history"></i> Past</button>
                
            </div>

            <div class="bookings-list" id="bookingsContainer">
                <div class="loading">
                    <i class="fas fa-spinner fa-3x fa-spin" style="color: var(--primary);"></i>
                    <p style="margin-top: 15px;">Loading your bookings...</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="animate__animated animate__fadeIn animate__delay-3s">
        <div class="container">
            <p>&copy; 2025 Ticketist. All rights reserved.</p>
            <p>Your gateway to unforgettable experiences</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script>
        // Enhanced sample data with more events
        const sampleBookings = [
            {
                id: 1,
                event_name: "Rock Festival 2023",
                event_date: "2023-12-15T19:00:00",
                event_location: "Central Park, New York",
                ticket_quantity: 2,
                ticket_price: 75.00,
                total_amount: 150.00,
                status: "confirmed",
                created_at: "2023-10-10T14:30:00"
            },
            {
                id: 2,
                event_name: "Jazz Night Under the Stars",
                event_date: "2026-11-20T20:00:00",
                event_location: "Blue Note Club, Chicago",
                ticket_quantity: 1,
                ticket_price: 45.00,
                total_amount: 45.00,
                status: "pending",
                created_at: "2023-10-15T09:15:00"
            },
            {
                id: 3,
                event_name: "Classical Symphony Gala",
                event_date: "2023-09-05T18:30:00",
                event_location: "Carnegie Hall, New York",
                ticket_quantity: 4,
                ticket_price: 60.00,
                total_amount: 240.00,
                status: "cancelled",
                created_at: "2023-08-20T11:45:00"
            },
            {
                id: 4,
                event_name: "Electronic Dance Festival",
                event_date: "2023-12-31T22:00:00",
                event_location: "Miami Beach, Florida",
                ticket_quantity: 3,
                ticket_price: 89.99,
                total_amount: 269.97,
                status: "confirmed",
                created_at: "2023-09-01T08:20:00"
            },
            {
                id: 5,
                event_name: "Broadway Musical: Hamilton",
                event_date: "2024-01-15T19:30:00",
                event_location: "Richard Rodgers Theatre, NYC",
                ticket_quantity: 2,
                ticket_price: 120.00,
                total_amount: 240.00,
                status: "pending",
                created_at: "2023-10-05T14:45:00"
            }
        ];

        document.addEventListener('DOMContentLoaded', function() {
            // Animate header elements sequentially
            gsap.from(".logo", {duration: 0.8, y: -50, opacity: 0, ease: "back.out(1)"});
            gsap.from("nav ul li", {
                duration: 0.6, 
                y: -20, 
                opacity: 0, 
                stagger: 0.1,
                delay: 0.3,
                ease: "back.out(1)"
            });

            // Load user bookings with animation
            setTimeout(() => {
                loadBookings();
            }, 1000);
            
            // Filter buttons functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Animate button click
                    gsap.to(this, {
                        duration: 0.2,
                        scale: 0.95,
                        yoyo: true,
                        repeat: 1,
                        ease: "power1.inOut"
                    });

                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    filterBookings(this.dataset.filter);
                });
            });
            
            // Logout functionality
            document.getElementById('logout').addEventListener('click', function(e) {
                e.preventDefault();
                // Animate logout button
                gsap.to(this, {
                    duration: 0.3,
                    scale: 1.2,
                    color: "#ff0000",
                    yoyo: true,
                    repeat: 1,
                    onComplete: () => {
                        alert('Logging out...');
                        window.location.href = 'login.html';
                    }
                });
            });
        });

        function loadBookings() {
            const container = document.getElementById('bookingsContainer');
            
            // Simulate loading delay
            setTimeout(() => {
                container.innerHTML = '';
                
                if (sampleBookings.length === 0) {
                    container.innerHTML = `
                        <div class="no-bookings animate__animated animate__fadeIn">
                            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076478.png" alt="No bookings" class="floating">
                            <h3>You have no bookings yet</h3>
                            <p>Explore our events and book your tickets now!</p>
                        </div>
                    `;
                    return;
                }
                
                sampleBookings.forEach((booking, index) => {
                    setTimeout(() => {
                        const bookingCard = createBookingCard(booking);
                        container.appendChild(bookingCard);
                        
                        gsap.from(bookingCard, {
                            duration: 0.5,
                            y: 50,
                            opacity: 0,
                            ease: "back.out(1)",
                            delay: index * 0.1
                        });
                    }, index * 100);
                });
            }, 800);
        }

        function createBookingCard(booking) {
            const bookingCard = document.createElement('div');
            bookingCard.className = 'booking-card';

            const eventDate = new Date(booking.event_date);
            const now = new Date();
            const isPast = eventDate < now;
            
            let statusText = booking.status;
            let statusClass = '';

            if (isPast) {
                statusText = 'past';
                statusClass = 'status-past';
            } else if (booking.status === 'confirmed') {
                statusText = 'upcoming';
                statusClass = 'status-confirmed';
            } else if (booking.status === 'pending') {
                statusText = 'upcoming';
                statusClass = 'status-pending';
            } else if (booking.status === 'cancelled') {
                statusText = 'cancelled';
                statusClass = 'status-cancelled';
            }
            
            const formattedDate = eventDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            let actionButtons = '';
            
            
            bookingCard.innerHTML = `
                <div class="booking-header">
                    <div class="booking-title">${booking.event_name}</div>
                    <div class="booking-status ${statusClass}">${statusText}</div>
                </div>
                <div class="booking-details">
                    <div class="booking-detail">
                        <div class="detail-label"><i class="far fa-calendar-alt"></i> Date:</div>
                        <div class="detail-value">${formattedDate}</div>
                    </div>
                    <div class="booking-detail">
                        <div class="detail-label"><i class="fas fa-map-marker-alt"></i> Location:</div>
                        <div class="detail-value">${booking.event_location}</div>
                    </div>
                    <div class="booking-detail">
                        <div class="detail-label"><i class="fas fa-ticket-alt"></i> Tickets:</div>
                        <div class="detail-value">${booking.ticket_quantity} x $${booking.ticket_price.toFixed(2)}</div>
                    </div>
                    <div class="booking-detail">
                        <div class="detail-label"><i class="fas fa-receipt"></i> Total:</div>
                        <div class="detail-value">$${booking.total_amount.toFixed(2)}</div>
                    </div>
                </div>
                <div class="booking-actions">
                    ${actionButtons}
                </div>
            `;
            
            bookingCard.addEventListener('mouseenter', () => {
                gsap.to(bookingCard, {
                    duration: 0.3,
                    y: -5,
                    boxShadow: "0 10px 25px rgba(0,0,0,0.15)",
                    ease: "power1.out"
                });
            });
            
            bookingCard.addEventListener('mouseleave', () => {
                gsap.to(bookingCard, {
                    duration: 0.3,
                    y: 0,
                    boxShadow: "0 5px 15px rgba(0,0,0,0.1)",
                    ease: "power1.out"
                });
            });
            
            const cancelBtn = bookingCard.querySelector('.cancel-btn');
            if (cancelBtn) {
                cancelBtn.addEventListener('click', () => {
                    const bookingId = cancelBtn.dataset.bookingId;
                    updateBookingStatus(bookingId, 'cancelled', bookingCard);
                });
            }
            
            return bookingCard;
        }

        function filterBookings(filter) {
            const bookings = document.querySelectorAll('.booking-card');
            
            gsap.to(bookings, {
                duration: 0.3,
                opacity: 0,
                y: 20,
                stagger: 0.05,
                onComplete: () => {
                    bookings.forEach(booking => {
                        const status = booking.querySelector('.booking-status').textContent.toLowerCase();
                        
                        if (filter === 'all' || 
                            (filter === 'upcoming' && status === 'upcoming') ||
                            (filter === 'past' && status === 'past') ||
                            (filter === 'cancelled' && status === 'cancelled')) {
                            booking.style.display = 'block';
                        } else {
                            booking.style.display = 'none';
                        }
                    });
                    
                    gsap.to('.booking-card', {
                        duration: 0.5,
                        opacity: 1,
                        y: 0,
                        stagger: 0.1,
                        ease: "back.out(1)"
                    });
                }
            });
        }

        function updateBookingStatus(bookingId, newStatus, bookingCard) {
            gsap.to(bookingCard, {
                duration: 0.5,
                backgroundColor: "#f8d7da",
                onComplete: () => {
                    const booking = sampleBookings.find(b => b.id == bookingId);
                    if (booking) {
                        booking.status = newStatus;
                    }
                    bookingCard.remove();
                    loadBookings();
                }
            });
        }
    </script>
</body>
</html>