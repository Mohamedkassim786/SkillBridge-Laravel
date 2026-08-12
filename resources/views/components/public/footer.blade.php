@php
    $siteName = \App\Models\CmsSetting::get('site_name', 'SkillBridge');
    $footerAbout = \App\Models\CmsSetting::get('footer_about', 'Enterprise-grade software learning platform connecting engineers to production architecture, live mentorship, and verified career placements.');
    $sitePhone = \App\Models\CmsSetting::get('site_phone', '+91 98765 43210');
    $siteEmail = \App\Models\CmsSetting::get('site_email', 'support@skillbridge.io');
    $siteAddress = \App\Models\CmsSetting::get('site_address', 'Chennai, India');
@endphp

<style>
    .footer-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
    }
    @media (min-width: 768px) {
        .footer-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (min-width: 1024px) {
        .footer-grid {
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
        }
    }
</style>

<footer style="background-color: #210f30; color: #d4c5e2; border-top: 1px solid rgba(241,81,83,0.2); font-size: 13px;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 64px 24px 48px;">
        <div class="footer-grid">
            <!-- Column 1: Brand Info & Social Icons -->
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 38px; height: 38px; border-radius: 10px; background: #f15153; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 18px; box-shadow: 0 4px 14px rgba(241,81,83,0.4); flex-shrink: 0;">
                        S
                    </div>
                    <span style="font-size: 18px; font-weight: 800; color: white; letter-spacing: -0.02em;">{{ $siteName }}</span>
                </div>

                <p style="color: #a997be; line-height: 1.6; max-width: 380px; margin: 0;">
                    {{ $footerAbout }}
                </p>

                <!-- Social Icons -->
                <div style="display: flex; align-items: center; gap: 10px; padding-top: 4px;">
                    <a href="#" title="LinkedIn" style="width: 32px; height: 32px; border-radius: 8px; background: #2b143e; border: 1px solid rgba(241,81,83,0.25); color: #f15153; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 12px; font-weight: 800;">in</a>
                    <a href="#" title="Twitter" style="width: 32px; height: 32px; border-radius: 8px; background: #2b143e; border: 1px solid rgba(241,81,83,0.25); color: #f15153; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 12px; font-weight: 800;">𝕏</a>
                    <a href="#" title="Facebook" style="width: 32px; height: 32px; border-radius: 8px; background: #2b143e; border: 1px solid rgba(241,81,83,0.25); color: #f15153; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 12px; font-weight: 800;">fb</a>
                    <a href="#" title="Instagram" style="width: 32px; height: 32px; border-radius: 8px; background: #2b143e; border: 1px solid rgba(241,81,83,0.25); color: #f15153; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 12px; font-weight: 800;">ig</a>
                    <a href="#" title="YouTube" style="width: 32px; height: 32px; border-radius: 8px; background: #2b143e; border: 1px solid rgba(241,81,83,0.25); color: #f15153; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 12px; font-weight: 800;">yt</a>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <h4 style="font-size: 12px; font-weight: 800; color: white; text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">Quick Links</h4>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                    <li><a href="{{ route('about') }}" style="color: #a997be; text-decoration: none;" onmouseover="this.style.color='#f15153'" onmouseout="this.style.color='#a997be'">About Us</a></li>
                    <li><a href="{{ route('contact') }}" style="color: #a997be; text-decoration: none;" onmouseover="this.style.color='#f15153'" onmouseout="this.style.color='#a997be'">Contact Support</a></li>
                    <li><a href="{{ route('pricing') }}" style="color: #a997be; text-decoration: none;" onmouseover="this.style.color='#f15153'" onmouseout="this.style.color='#a997be'">Pricing Plans</a></li>
                    <li><a href="{{ route('faq') }}" style="color: #a997be; text-decoration: none;" onmouseover="this.style.color='#f15153'" onmouseout="this.style.color='#a997be'">Frequently Asked Questions</a></li>
                </ul>
            </div>

            <!-- Column 3: Courses -->
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <h4 style="font-size: 12px; font-weight: 800; color: white; text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">Courses</h4>
                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                    <li><a href="{{ route('courses.index') }}" style="color: #a997be; text-decoration: none;" onmouseover="this.style.color='#f15153'" onmouseout="this.style.color='#a997be'">Laravel Development</a></li>
                    <li><a href="{{ route('courses.index') }}" style="color: #a997be; text-decoration: none;" onmouseover="this.style.color='#f15153'" onmouseout="this.style.color='#a997be'">React & Frontend</a></li>
                    <li><a href="{{ route('courses.index') }}" style="color: #a997be; text-decoration: none;" onmouseover="this.style.color='#f15153'" onmouseout="this.style.color='#a997be'">Python & Data</a></li>
                    <li><a href="{{ route('courses.index') }}" style="color: #a997be; text-decoration: none;" onmouseover="this.style.color='#f15153'" onmouseout="this.style.color='#a997be'">Java Enterprise</a></li>
                    <li><a href="{{ route('courses.index') }}" style="color: #a997be; text-decoration: none;" onmouseover="this.style.color='#f15153'" onmouseout="this.style.color='#a997be'">Automated Testing</a></li>
                    <li><a href="{{ route('courses.index') }}" style="color: #a997be; text-decoration: none;" onmouseover="this.style.color='#f15153'" onmouseout="this.style.color='#a997be'">Cloud & DevOps</a></li>
                </ul>
            </div>

            <!-- Column 4: Contact -->
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <h4 style="font-size: 12px; font-weight: 800; color: white; text-transform: uppercase; letter-spacing: 0.1em; margin: 0;">Contact</h4>
                <div style="display: flex; flex-direction: column; gap: 10px; color: #d4c5e2; font-size: 12.5px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg width="15" height="15" fill="none" stroke="#f15153" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>{{ $siteEmail }}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg width="15" height="15" fill="none" stroke="#f15153" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>{{ $sitePhone }}</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg width="15" height="15" fill="none" stroke="#f15153" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $siteAddress }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div style="margin-top: 48px; padding-top: 32px; border-top: 1px solid rgba(241,81,83,0.15); display: flex; flex-wrap: wrap; items-center; justify-content: space-between; gap: 16px; color: #8e7c9f; font-size: 12px;">
            <div>
                © {{ date('Y') }} {{ $siteName }}. All rights reserved.
            </div>
            <div style="display: flex; align-items: center; gap: 20px;">
                <a href="#" style="color: #8e7c9f; text-decoration: none;" onmouseover="this.style.color='#f15153'" onmouseout="this.style.color='#8e7c9f'">Terms of Service</a>
                <a href="#" style="color: #8e7c9f; text-decoration: none;" onmouseover="this.style.color='#f15153'" onmouseout="this.style.color='#8e7c9f'">Privacy Policy</a>
                <a href="#" style="color: #8e7c9f; text-decoration: none;" onmouseover="this.style.color='#f15153'" onmouseout="this.style.color='#8e7c9f'">Refund Policy</a>
            </div>
        </div>
    </div>
</footer>
