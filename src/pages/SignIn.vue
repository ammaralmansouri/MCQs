<template>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-500 to-indigo-600">
      <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-sm">
        <!-- Logo Section -->
        <div class="flex justify-center mb-6">
          <div class="w-16 h-16 bg-blue-500 text-white flex items-center justify-center rounded-full text-xl font-bold">
            MCQ
          </div>
        </div>
  
        <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Sign In</h2>
  
        <form @submit.prevent="login">
          <!-- Email Input -->
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              v-model="email"
              type="email"
              id="email"
              name="email"
              class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Enter your email"
              required
            />
          </div>
  
          <!-- Password Input -->
          <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
              v-model="password"
              type="password"
              id="password"
              name="password"
              class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Enter your password"
              required
            />
          </div>
  
          <!-- Login Button -->
          <button
            type="submit"
            class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition shadow-md font-semibold"
          >
            Sign In
          </button>
  
          <!-- Error Message -->
          <p v-if="errorMessage" class="text-red-500 text-sm mt-3 text-center">
            {{ errorMessage }}
          </p>
        </form>
  
        <!-- Register Link -->
        <p class="text-center text-sm text-gray-600 mt-4">
          Don't have an account?
          <router-link
            :to="{ name: 'signup' }"
            class="text-blue-500 hover:underline font-semibold"
          >
            Register
          </router-link>
        </p>
      </div>
    </div>
  </template>
  
  <script setup>
  import axios from "@/axios";
  import { ref } from "vue";
  import { useRouter } from "vue-router";
  
  const email = ref("");
  const password = ref("");
  const errorMessage = ref("");
  const router = useRouter();
  
  const login = async () => {
    try {
      const response = await axios.post("/login", {
        email: email.value,
        password: password.value,
      });
  
      if (response.data.token) {
        localStorage.setItem("token", response.data.token);
        localStorage.setItem("user_id", response.data.user.id);
        router.push("/home");
      } else {
        errorMessage.value = "No token received from server.";
      }
    } catch (error) {
      console.log(error);
      errorMessage.value = error.response?.data?.message || "Login failed";
    }
  };
  </script>
  