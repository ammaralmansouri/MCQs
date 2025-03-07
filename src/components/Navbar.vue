<template>
  <nav class="bg-gradient-to-r from-blue-700 to-blue-900 text-white px-6 py-4 shadow-md flex items-center justify-between">
    <!-- Logo & Title -->
    <div class="flex items-center space-x-3">
      <h1 class="text-2xl font-extrabold tracking-wide">MCQ System</h1>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center space-x-6">
     

      <!-- User Profile  -->
      <div class="relative">
        <button @click="toggleDropdown" class="flex items-center space-x-2 transition">
          <img src="../assets/images/user.jpg" alt="User" class="w-8 h-8 rounded-full border-2 border-white" />
        </button>

        <!-- Dropdown Menu -->
        <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-40 bg-white text-gray-900 rounded-md shadow-lg py-2">
          <button class="block px-4 py-2 hover:bg-gray-200 w-full text-left">Profile</button>
          <button class="block px-4 py-2 hover:bg-gray-200 w-full text-left">Logout</button>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from "vue";

const dropdownOpen = ref(false);

const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value;
};
</script>
