<template>
  <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <Sidebar />

    <div class="flex-1 p-6">
      <!-- Navbar -->
      <Navbar />

      <h2 class="text-3xl font-bold mb-6 text-gray-800 mt-5">
        Available Tests
      </h2>

      <!-- Loading State -->
      <div v-if="loading" class="text-center text-gray-500 text-lg">
        Loading...
      </div>

      <!-- Tests Grid -->
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="test in tests"
          :key="test.id"
          class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1"
          :class="{
            'opacity-50 cursor-not-allowed': completedTests.includes(test.id),
          }"
        >
          <!-- Checkmark for Completed Tests -->
          <div
            v-if="completedTests.includes(test.id)"
            class="absolute top-3 right-3 bg-green-500 text-white p-2 rounded-full"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 16 16"
            >
              <path
                d="M8 16a8 8 0 1 1 8-8 8 8 0 0 1-8 8ZM8 0a8 8 0 1 0 8 8A8 8 0 0 0 8 0Zm3.646 5.354a.5.5 0 0 0-.708-.708L7 9.293 4.354 6.646a.5.5 0 0 0-.708.708L7 10.707l5.646-5.353z"
              />
            </svg>
          </div>
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
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                ></path>
              </svg>
              <span class="text-sm font-medium">
                Duration: {{ test.test_duration }} M
              </span>
            </div>
            <div class="flex items-center space-x-1">
              <svg
                class="w-5 h-5 text-green-500"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8 10h.01M12 10h.01M16 10h.01M9 16h6"
                ></path>
              </svg>
              <span class="text-sm font-medium">
                Questions: {{ test.questions_count }}
              </span>
            </div>

            <button
              @click="goToQuestions(test.id)"
              :disabled="completedTests.includes(test.id)"
              class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition"
            >
              Take Test
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import Sidebar from "../components/Sidebar.vue";
import Navbar from "../components/Navbar.vue";
import axios from "@/axios";

const tests = ref([]);
const completedTests = ref([]); // Array to store completed test IDs
const loading = ref(true);
const router = useRouter();

onMounted(async () => {
  try {
    // Fetch tests
    const response = await axios.get("/tests");
    tests.value = response.data;

    // Fetch completed tests for the user
    const userId = localStorage.getItem("user_id");
    const completedResponse = await axios.get("/completed-tests", {
      params: { user_id: userId }, // Pass user ID dynamically
    });
    completedTests.value = completedResponse.data;
    loading.value = false;
  } catch (error) {
    console.error("Error fetching tests or completed tests:", error);
  }
});

const goToQuestions = (testId) => {
  router.push(`/tests/${testId}/questions`);
};
</script>
