<div class="space-y-8">
    <!-- 1. Welcome Banner -->
    <livewire:student.widgets.welcome-banner />

    <!-- 2. Learning Statistics Grid (7 Metric Cards) -->
    <livewire:student.widgets.learning-statistics />

    <!-- Main Grid Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left 2 Columns -->
        <div class="lg:col-span-2 space-y-8">
            <!-- 3. Continue Learning -->
            <livewire:student.widgets.continue-learning />

            <!-- 4. Upcoming Live Classes -->
            <livewire:student.widgets.upcoming-classes />

            <!-- 5. Pending Assignments -->
            <livewire:student.widgets.pending-assignments />

            <!-- 6. Upcoming Quizzes -->
            <livewire:student.widgets.upcoming-quizzes />

            <!-- 7. Recent Certificates -->
            <livewire:student.widgets.recent-certificates />
        </div>

        <!-- Right 1 Column -->
        <div class="space-y-8">
            <!-- 13. Quick Actions -->
            <livewire:student.widgets.quick-actions />

            <!-- 14. AI Insight Card -->
            <livewire:student.widgets.ai-insight-card />

            <!-- 10. Career Progress -->
            <livewire:student.widgets.career-progress />

            <!-- 11. Learning Calendar -->
            <livewire:student.widgets.learning-calendar />

            <!-- 12. Latest Notifications -->
            <livewire:student.widgets.notifications-widget />
        </div>
    </div>

    <!-- Full-Width Bottom Sections -->
    <div class="space-y-8">
        <!-- 8. Recommended Courses -->
        <livewire:student.widgets.recommended-courses />

        <!-- 9. Recommended Jobs -->
        <livewire:student.widgets.recommended-jobs />
    </div>
</div>
