<header class="dash-header" id="dashHeader">
    <div class="dash-header__inner">

        <a href="{{ route('dashboard') }}" class="dash-brand" aria-label="My App">
            <div class="dash-brand__mark">MA</div>
            <div class="dash-brand__text">
                <span class="dash-brand__name">Multi-Department Payroll MS</span>
                <span class="dash-brand__sub">Dashboard</span>
            </div>
        </a>

        <nav class="dash-nav" id="dashNav" aria-label="Dashboard navigation">
            <ul class="dash-nav__list">
                <li class="dash-nav__item" style="--i:0">
                    <a href="{{ route('dashboard') }}"
                        class="dash-nav__link{{ request()->routeIs('dashboard') ? ' is-active' : '' }}">
                        <svg class="dash-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li class="dash-nav__item" style="--i:1">
                    <a href="{{ route('departments') }}"
                        class="dash-nav__link{{ request()->routeIs('departments*') ? ' is-active' : '' }}">
                        <svg class="dash-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 9l0 .01" />
                            <path d="M6 20h12a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2" />
                            <path d="M3 9h18" />
                            <path d="M9 9v11" />
                            <path d="M15 9v11" />
                        </svg>
                        Departments
                    </a>
                </li>
                <li class="dash-nav__item" style="--i:2">
                    <a href="{{ route('employees') }}"
                        class="dash-nav__link{{ request()->routeIs('employees*') ? ' is-active' : '' }}">
                        <svg class="dash-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M9 7a4 4 0 1 1 8 0a4 4 0 0 1 -8 0" />
                            <path d="M3 21v-2a6 6 0 0 1 6 -6h6a6 6 0 0 1 6 6v2" />
                        </svg>
                        Employees
                    </a>
                </li>
                <li class="dash-nav__item" style="--i:3">
                    <a href="{{ route('payroll') }}"
                        class="dash-nav__link{{ request()->routeIs('payroll') ? ' is-active' : '' }}">
                        <svg class="dash-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="7" cy="7" r="2" />
                            <circle cx="17" cy="17" r="2" />
                            <path d="M6 18l12 -12" />
                        </svg>
                        Payroll
                    </a>
                </li>
                <li class="dash-nav__item" style="--i:4">
                    <a href="{{ route('payroll-history') }}"
                        class="dash-nav__link{{ request()->routeIs('payroll-history*') ? ' is-active' : '' }}">
                        <svg class="dash-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l4 2" />
                            <path d="M21 12a9 9 0 1 1 -18 0a9 9 0 0 1 18 0" />
                        </svg>
                        Payroll History
                    </a>
                </li>
            </ul>
        </nav>

        <div class="dash-actions">
            <button class="dash-theme-toggle" id="dashThemeToggle" aria-label="Switch to light mode" title="Switch to light mode"></button>

            <div class="dash-user" id="dashUser">
                <button class="dash-user__trigger" id="dashUserTrigger"
                    aria-expanded="false" aria-haspopup="true">
                    <span class="dash-user__avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    <span class="dash-user__name">
                        {{ Auth::user()->name }}
                    </span>
                    <svg class="dash-user__chevron" viewBox="0 0 24 24" aria-hidden="true">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>

                <div class="dash-user__dropdown" id="dashUserDropdown" role="menu">
                    <div class="dash-user__header">
                        <p class="dash-user__label">Signed in as</p>
                        <p class="dash-user__email">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="dash-user__separator"></div>
                    <a href="{{ url('/') }}" class="dash-user__item" role="menuitem" target="_blank" rel="noopener noreferrer">
                        <svg class="dash-icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                        View Site
                    </a>
                    <div class="dash-user__separator"></div>
                    <form method="POST" action="{{ route('logout') }}" id="dashLogoutForm">
                        @csrf
                        <button type="submit" class="dash-user__item dash-user__item--danger" role="menuitem">
                            <svg class="dash-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <button class="dash-toggle" id="dashNavToggle" aria-label="Toggle navigation" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>
</header>