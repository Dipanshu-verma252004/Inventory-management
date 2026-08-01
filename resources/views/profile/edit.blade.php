<x-app-layout>
    <div class="profile-container">
        <section class="profile-hero-card">
            <div class="profile-breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span>/</span> Account settings</div>
            <div class="profile-hero-content">
                <div class="profile-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div>
                    <h1>Account settings</h1>
                    <p>Manage your personal details and account security.</p>
                </div>
            </div>
        </section>

        <div class="profile-settings-grid">
            <aside class="profile-sidebar">
                <p class="profile-sidebar-title">SETTINGS</p>
                <a class="active" href="#personal-details"><i class="icon-base bx bx-user"></i> Personal details</a>
                <a href="#security"><i class="icon-base bx bx-lock-alt"></i> Password & security</a>
                <a href="#danger-zone"><i class="icon-base bx bx-trash"></i> Danger zone</a>
            </aside>
            <div class="profile-cards">
                <article id="personal-details" class="profile-card">
                    @include('profile.partials.update-profile-information-form')
                </article>
                <article id="security" class="profile-card">
                    @include('profile.partials.update-password-form')
                </article>
                <article id="danger-zone" class="profile-card profile-danger-card">
                    @include('profile.partials.delete-user-form')
                </article>
            </div>
        </div>
    </div>
</x-app-layout>
