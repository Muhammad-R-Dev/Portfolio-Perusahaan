<style>
/* ============ FOOTER CTA BANNER ============ */
.footer-cta {
    position: relative;
    background-color: #094356;
    background-image:
        linear-gradient(90deg,
            #094356 0%,
            #094356 32%,
            rgba(9, 67, 86, 0.92) 45%,
            rgba(9, 67, 86, 0.55) 62%,
            rgba(9, 67, 86, 0.15) 80%,
            rgba(9, 67, 86, 0) 100%
        ),
        url('https://images.unsplash.com/photo-1587702068694-a909ef4aa346?fm=jpg&q=80&w=1600&auto=format&fit=crop');
    background-repeat: no-repeat;
    background-position: right center;
    background-size: cover;
    padding: 3.5rem 2rem;
    font-family: 'Poppins', sans-serif;
}
.footer-cta-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}
.footer-cta-text h3 {
    font-family: 'Sora', sans-serif;
    color: #ffffff;
    font-size: 1.9rem;
    font-weight: 700;
    margin: 0 0 0.6rem;
}
.footer-cta-text p {
    color: rgba(255, 255, 255, 0.75);
    font-size: 1rem;
    margin: 0;
}
.footer-cta-actions {
    display: flex;
    align-items: center;
    gap: 1.8rem;
    flex-wrap: wrap;
}
.footer-cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    background: #ffffff;
    color: #094356;
    font-weight: 600;
    font-size: 0.95rem;
    padding: 0.9rem 1.6rem;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
    white-space: nowrap;
}
.footer-cta-btn:hover {
    background: #4FA8B5;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(79, 168, 181, 0.3);
}
.footer-cta-phone {
    display: flex;
    align-items: center;
    gap: 0.7rem;
    color: #ffffff;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    white-space: nowrap;
}
.footer-cta-phone i {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
}

@media (max-width: 768px) {
    .footer-cta {
        background-image:
            linear-gradient(180deg,
                rgba(9, 67, 86, 0.75) 0%,
                rgba(9, 67, 86, 0.88) 40%,
                #094356 75%
            ),
            url('https://images.unsplash.com/photo-1587702068694-a909ef4aa346?fm=jpg&q=80&w=1600&auto=format&fit=crop');
        background-position: center center;
        background-size: cover;
        padding: 2.2rem 1.5rem;
    }
    .footer-cta-inner {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
        gap: 1.2rem;
    }
    .footer-cta-text h3 {
        font-size: 1.3rem;
    }
    .footer-cta-text p {
        font-size: 0.85rem;
    }
    .footer-cta-actions {
        gap: 1rem;
    }
    .footer-cta-btn {
        font-size: 0.85rem;
        padding: 0.7rem 1.3rem;
    }
    .footer-cta-phone {
        font-size: 0.85rem;
    }
    .footer-cta-phone i {
        width: 34px;
        height: 34px;
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .footer-cta {
        padding: 1.8rem 1.2rem;
    }
    .footer-cta-text h3 {
        font-size: 1.1rem;
    }
    .footer-cta-text p {
        font-size: 0.8rem;
    }
}

/* ============ FOOTER ============ */
.custom-footer {
    background-color: #094356;
    color: rgba(255, 255, 255, 0.7);
    padding: 3rem 2rem 2rem;
    font-family: 'Poppins', sans-serif;
    border-top: 1px solid rgba(79, 168, 181, 0.08);
    position: relative;
    overflow: hidden;
}
.custom-footer::before {
    content: '';
    position: absolute;
    top: -150px;
    right: -150px;
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(159,214,185,0.06) 0%, transparent 70%);
    pointer-events: none;
}
.custom-footer::after {
    content: '';
    position: absolute;
    bottom: -100px;
    left: -100px;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(159,214,185,0.04) 0%, transparent 70%);
    pointer-events: none;
}
.footer-container {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr;
    gap: 3rem;
    margin-bottom: 3rem;
    position: relative;
    z-index: 1;
}
.footer-brand h2 {
    font-family: 'Sora', sans-serif;
    color: #ffffff;
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 1.2rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.footer-brand p {
    font-size: 0.95rem;
    line-height: 1.8;
    margin-bottom: 1.8rem;
}
.social-links {
    display: flex;
    gap: 1rem;
}
.social-links a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.1rem;
}
.social-links a:hover {
    background: #ffffff;
    color: #094356;
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(255, 255, 255, 0.2);
}
.footer-links h4, .footer-contact h4 {
    font-family: 'Sora', sans-serif;
    color: #ffffff;
    font-size: 1.1rem;
    margin-bottom: 1.4rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    position: relative;
    padding-bottom: 12px;
}
.footer-links h4::after, .footer-contact h4::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 30px;
    height: 2px;
    background: #4FA8B5;
    border-radius: 2px;
}
.footer-links ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.footer-links li {
    margin-bottom: 1rem;
}
.footer-links a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    position: relative;
    padding-left: 0;
}
.footer-links a:hover {
    color: #4FA8B5;
    padding-left: 8px;
}
.footer-contact p {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    font-size: 0.95rem;
    margin-bottom: 1.2rem;
    line-height: 1.6;
}
.footer-contact i {
    color: #ffffff;
    margin-top: 4px;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.footer-divider {
    max-width: 1100px;
    margin: 0 auto;
    border: none;
    border-top: 1px solid rgba(255, 255, 255, 0.06);
}
.footer-bottom {
    max-width: 1100px;
    margin: 0 auto;
    padding-top: 1.8rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.4);
    position: relative;
    z-index: 1;
}
.footer-bottom-links {
    display: flex;
    gap: 20px;
}
.footer-bottom-links a {
    color: rgba(255, 255, 255, 0.4);
    text-decoration: none;
    transition: color 0.3s ease;
}
.footer-bottom-links a:hover {
    color: #4FA8B5;
}

@media (max-width: 768px) {
    .custom-footer {
        padding: 2.5rem 1.5rem 1.5rem;
    }
    .footer-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    .footer-brand h2 {
        font-size: 1.3rem;
    }
    .footer-brand p {
        font-size: 0.85rem;
    }
    .footer-links h4, .footer-contact h4 {
        font-size: 1rem;
    }
    .footer-links a {
        font-size: 0.85rem;
    }
    .footer-contact p {
        font-size: 0.85rem;
    }
    .footer-bottom {
        flex-direction: column;
        gap: 10px;
        text-align: center;
        font-size: 0.8rem;
    }
}
</style>

<!-- ============ CTA BANNER (with background photo + smooth gradient blend) ============ -->
<div class="footer-cta">
    <div class="footer-cta-inner">
        <div class="footer-cta-text">
            <h3>Siap Mewujudkan Ide Digital Anda?</h3>
            <p>Mari wujudkan tujuan bisnis Anda bersama kami.</p>
        </div>
        <div class="footer-cta-actions">
        </div>
    </div>
</div>

<footer class="custom-footer">
    <div class="footer-container">
        <div class="footer-brand">
            <h2>Asta Brata</h2>
            <p>Membawa inovasi digital untuk masa depan bisnis yang lebih baik melalui teknologi yang handal dan desain yang intuitif.</p>
            <div class="social-links">
                <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#" aria-label="GitHub"><i class="fa-brands fa-github"></i></a>
                <a href="#" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>
        
        <div class="footer-links">
            <h4>Tautan Cepat</h4>
            <ul>
                <li><a href="{{ url('/') }}">Beranda</a></li>
                <li><a href="{{ url('/projects') }}">Project</a></li>
                <li><a href="{{ url('/about') }}">About</a></li>
                <li><a href="{{ url('/contact') }}">Contact</a></li>
            </ul>
        </div>
        
        <div class="footer-contact">
            <h4>Hubungi Kami</h4>
            <p><i class="fa-solid fa-location-dot"></i> <span>Jl.STPP karanglo, Area Sawah/Kebun, Glagahombo, Tegalrejo, Magelang, Jawa Tengah 56192</span></p>
            <p><i class="fa-solid fa-phone"></i> <span>+62 882 0066 44656</span></p>
            <p><i class="fa-solid fa-envelope"></i> <span>astabratamgl@gmail.com</span></p>
        </div>
    </div>
    
    <hr class="footer-divider">
    
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} PT Asta Brata Teknologi. All rights reserved.</p>
        <div class="footer-bottom-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
        </div>
    </div>
</footer>