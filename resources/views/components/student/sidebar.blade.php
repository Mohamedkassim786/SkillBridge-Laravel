<!-- 1. MOBILE BACKDROP & DRAWER (Mobile/Tablet Only: < lg) -->
<div x-show="sidebarOpen" x-cloak class="relative z-50 lg:hidden">
    <!-- Backdrop Overlay -->
    <div @click="sidebarOpen = false" 
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-purple-950/80 backdrop-blur-sm"></div>

    <!-- Mobile Slide-over Panel -->
    <aside x-transition:enter="transition ease-in-out duration-300 transform"
           x-transition:enter-start="-translate-x-full"
           x-transition:enter-end="translate-x-0"
           x-transition:leave="transition ease-in-out duration-300 transform"
           x-transition:leave-start="translate-x-0"
           x-transition:leave-end="-translate-x-full"
           style="background-color: #210f30; border-right: 1px solid rgba(241,81,83,0.2);"
           class="fixed inset-y-0 left-0 top-16 z-50 w-64 text-purple-100 flex flex-col justify-between overflow-y-auto">
        <x-student.sidebar-content />
    </aside>
</div>

<!-- 2. DESKTOP STICKY SIDEBAR (Desktop Only: lg+) -->
<aside style="background-color: #210f30; border-right: 1px solid rgba(241,81,83,0.2);" class="hidden lg:flex flex-col justify-between w-64 shrink-0 text-purple-100 sticky top-16 h-[calc(100vh-4rem)] overflow-y-auto z-20">
    <x-student.sidebar-content />
</aside>
