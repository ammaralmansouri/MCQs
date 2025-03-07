<template>
  <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <Sidebar />

    <div class="flex-1 p-6">
      <!-- Navbar -->
      <Navbar />

      <h2 class="text-3xl font-bold mb-6 text-gray-800 mt-5">
        Tests I Have Done
      </h2>

      <!-- Loading State -->
      <div v-if="loading" class="text-center text-gray-500 text-lg">
        Loading...
      </div>

      <!-- Tests Grid -->
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="test in completedTests"
          :key="test.id"
          class="relative bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1"
        >
          <!-- Checkmark for Completed Tests -->
          <div
            class="absolute top-3 right-3 bg-blue-500 text-white p-2 rounded-full"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 16 16"
            >
              <path
                d="M8 16A8 8 0 1 1 16 8 8 8 0 0 1 8 16ZM8 1a7 7 0 1 0 7 7A7 7 0 0 0 8 1Z"
              />
              <path
                d="m8.93 6.588-.258 4.036a.5.5 0 0 1-.498.466h-.346a.5.5 0 0 1-.497-.57l.273-3.285a.25.25 0 0 0-.25-.27h-.264a.5.5 0 0 1 0-1h1.527a.5.5 0 0 1 .5.553Zm-.895-2.863a.905.905 0 1 1 1.809 0 .905.905 0 0 1-1.809 0Z"
              />
            </svg>
          </div>

          <!-- Test Details -->
          <h3 class="text-xl font-semibold text-blue-600">
            {{ test.test_title }}
          </h3>
          <p class="text-gray-600 mt-2">{{ test.test_description }}</p>

          <div class="mt-4 flex items-center justify-between text-gray-700">
            <div class="flex items-center space-x-1">
              <svg
                class="w-5 h-5 text-gray-500"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                ></path>
              </svg>
              <span class="text-sm font-medium">
                Duration: {{ test.test_duration }} min
              </span>
            </div>

            <div class="flex items-center space-x-1">
              <svg
                class="w-5 h-5 text-green-500"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8 10h.01M12 10h.01M16 10h.01M9 16h6"
                ></path>
              </svg>
              <span class="text-sm font-medium">
                Score: {{ test.pivot?.score ?? "N/A" }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Sidebar from "../components/Sidebar.vue";
import Navbar from "../components/Navbar.vue";
import axios from "@/axios";

const completedTests = ref([]);
const loading = ref(true);

onMounted(async () => {
  try {
    loading.value = true;
    const userId = localStorage.getItem("user_id"); 

    console.log("User ID:", userId);

    // Fetch user's completed tests
    const response = await axios.get(`/achievements/${userId}`);

    console.log("API Response:", response.data); // Debugging

    if (!response.data.tests || response.data.tests.length === 0) {
      console.warn("No completed tests found for this user.");
      loading.value = false;
      return;
    }

    // Set completed tests
    completedTests.value = response.data.tests;
    loading.value = false;
  } catch (error) {
    console.error("Error fetching completed tests:", error);
    loading.value = false;
  }
});
</script>
