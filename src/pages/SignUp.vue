<template>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-green-500 to-blue-500">
      <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-sm">
        <!-- Logo Placeholder -->
        <div class="flex justify-center mb-6">
          <div class="w-16 h-16 bg-green-500 text-white flex items-center justify-center rounded-full text-xl font-bold">
            MCQ
          </div>
        </div>
  
        <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6">Create Account</h2>
  
        <form @submit.prevent="signup">
          <!-- Full Name -->
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input
              v-model="fullName"
              type="text"
              id="name"
              name="name"
              class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="Enter your full name"
              required
            />
          </div>
  
          <!-- Email -->
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              v-model="email"
              type="email"
              id="email"
              name="email"
              class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="Enter your email"
              required
            />
          </div>
  
          <!-- Password -->
          <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
              v-model="password"
              type="password"
              id="password"
              name="password"
              class="mt-2 p-3 w-full border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="Create a password"
              required
            />
          </div>
  
          <!-- Sign Up Button -->
          <button
            type="submit"
            class="w-full bg-green-500 text-white p-3 rounded-lg hover:bg-green-600 transition shadow-md font-semibold"
          >
            Sign Up
          </button>
  
          <!-- Error Message -->
          <p v-if="errorMessage" class="text-red-500 mt-3 text-center text-sm">
            {{ errorMessage }}
          </p>
        </form>
  
        <!-- Sign In Link -->
        <p class="text-center text-sm text-gray-600 mt-4">
          Already have an account?
          <router-link :to="{ name: 'signin' }" class="text-blue-500 hover:underline font-semibold">
            Sign In
          </router-link>
        </p>
      </div>
    </div>
  </template>
  
  <script setup>
  import axios from "@/axios";
  import { ref } from "vue";
  import { useRouter } from "vue-router";
  
  // Data
  const fullName = ref("");
  const email = ref("");
  const password = ref("");
  const errorMessage = ref("");
  
  // Router
  const router = useRouter();
  
  // Signup function
  const signup = async () => {
    try {
      const userResponse = await axios.post("/signup", {
        name: fullName.value,
        email: email.value,
        password: password.value,
      });
      router.push("/");
    } catch (error) {
      console.error(error);
      errorMessage.value = error.response?.data?.message || "Signup failed";
    }
  };
  </script>
  