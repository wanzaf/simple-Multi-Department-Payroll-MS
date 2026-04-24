<footer class="dash-footer">
    <div class="dash-footer__inner">
        <p class="dash-footer__copy">
            &copy; {{ date('Y') }} <strong>Multi-Department Payroll MS</strong> &mdash; Dashboard
        </p>
        <ul class="dash-footer__links">
            <li><a href="{{ route('dashboard') }}" class="dash-footer__link">Dashboard</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="dash-footer__link" style="background:none;border:none;cursor:pointer;font:inherit;padding:0">Sign Out</button>
                </form>
            </li>
        </ul>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
