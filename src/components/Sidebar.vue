<template>
  <aside
    class="bg-gray-900 w-64 text-white min-h-screen p-4 flex flex-col transition-all duration-300 overflow-y-auto"
  >
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-bold">Navigation</h2>
    </div>

    <!-- Navigation -->
    <nav class="mt-6">
      <ul>
        <router-link :to="{ name: 'home' }">
          <li
            class="flex items-center space-x-3 py-2 px-3 rounded-lg hover:bg-gray-700 transition"
          >
            <span class="material-icons">All Test</span>
          </li>
        </router-link>
        <router-link :to="{ name: 'ahievements' }">
          <li
            class="flex items-center space-x-3 py-2 px-3 rounded-lg hover:bg-gray-700 transition"
          >
            <span class="material-icons">My achievements</span>
          </li>
        </router-link>
      </ul>
    </nav>
  </aside>
</template>

<script setup></script>
