<template>
  <div class="flex min-h-screen bg-gray-100">
    <Sidebar />
    <div class="flex-1 p-6">
      <Navbar />
      <!-- Timer Display -->
      <!-- Sticky Header -->
      <div class="sticky top-0 z-10 bg-white shadow-md mb-6">
        <div class="flex justify-between items-center p-4">
          <h2 class="text-3xl font-bold text-gray-800">{{ testTitle }}</h2>
          <div class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md">
            Time Remaining: {{ formattedTime }}
          </div>
        </div>
      </div>
      <div v-if="loading" class="flex justify-center items-center h-64">
        <div
          class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"
        ></div>
      </div>
      <div v-else>
        <!-- Questions List -->
        <div
          v-for="(question, index) in questions"
          :key="question.id"
          class="border p-6 rounded-lg shadow-sm bg-white mb-6"
        >
          <h3 class="text-xl font-semibold text-gray-700 mb-4">
            Q{{ index + 1 }}: {{ question.question_text }}
          </h3>
          <ul class="space-y-2">
            <li
              v-for="(choice, choiceIndex) in question.choices"
              :key="choice.id"
              @click="selectAnswer(question.id, choice.id)"
              :class="{
                'bg-blue-50 border-blue-500':
                  selectedAnswers[question.id] === choice.id,
                'border-gray-200 hover:bg-gray-50':
                  selectedAnswers[question.id] !== choice.id,
              }"
              class="border p-3 rounded-lg cursor-pointer transition duration-200 flex items-center"
            >
              <!-- Choice Label (A, B, C, D) -->
              <span
                class="w-6 h-6 flex items-center justify-center bg-blue-500 text-white rounded-full mr-3"
              >
                {{ String.fromCharCode(65 + choiceIndex) }}
                <!-- 65 = 'A' in ASCII -->
              </span>
              <span>{{ choice.choice_text }}</span>
            </li>
          </ul>
        </div>

        <!-- End Exam Button -->
        <div class="fixed bottom-6 right-6">
          <button
            @click="endExam"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-lg transition duration-200 transform hover:scale-105"
          >
            End Exam
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, computed, watch } from "vue";
import { useRouter } from "vue-router";
import { useRoute } from "vue-router";
import Sidebar from "../components/Sidebar.vue";
import Navbar from "../components/Navbar.vue";
import axios from "@/axios";

const router = useRouter();
const route = useRoute();
const testId = route.params.id;
const testTitle = ref("");
const testduration = ref(0); // Initialize with 0
const questions = ref([]);
const loading = ref(true);
const selectedAnswers = ref({}); // Stores user's selected answers: { questionId: choiceId }

// Timer Logic
const timeRemaining = ref(0); // Initialize with 0
let timerInterval = null;

// Watch testduration and initialize the timer when it changes
watch(
  () => testduration.value, // Watch the value of testduration
  (newDuration) => {
    if (newDuration > 0) {
      console.log("Test duration updated:", newDuration); // Debugging log
      timeRemaining.value = newDuration * 60; // Convert minutes to seconds
      startTimer(); // Start the timer
    }
  },
  { immediate: true } // Trigger the watch immediately if testduration changes
);

// Start the timer when the component mounts
onMounted(() => {
  fetchQuestions();
});

// Format time as MM:SS
const formattedTime = computed(() => {
  const minutes = Math.floor(timeRemaining.value / 60);
  const seconds = timeRemaining.value % 60;
  return `${String(minutes).padStart(2, "0")}:${String(seconds).padStart(
    2,
    "0"
  )}`;
});

// Start the countdown timer
const startTimer = () => {
  console.log("Starting timer..."); // Debugging log
  if (timerInterval) clearInterval(timerInterval); // Clear any existing interval
  timerInterval = setInterval(() => {
    if (timeRemaining.value > 0) {
      timeRemaining.value--;
      console.log("Time remaining:", formattedTime.value); // Debugging log
    } else {
      clearInterval(timerInterval); // Clear interval when time runs out
      console.log("Time's up! Ending exam..."); // Debugging log
      endExam(); // Call endExam function when time reaches zero
    }
  }, 1000);
};

// Handle end exam
const endExam = async () => {
  console.log("Ending exam..."); // Debugging log to ensure endExam is called
  clearInterval(timerInterval); // Stop the timer explicitly just in case
  
  let correctAnswers = 0;
  let answeredQuestions = 0;
  const results = [];

  questions.value.forEach((question) => {
    const userChoiceId = selectedAnswers.value[question.id];
    
    if (userChoiceId) {
      answeredQuestions++;
      const isCorrect = question.choices.find(c => c.id === userChoiceId)?.is_correct;
      
      if (isCorrect) correctAnswers++;

      results.push({
        question_id: question.id,
        choice_id: userChoiceId,
        is_correct: isCorrect ? 1 : 0
      });
    }
  });

  const totalQuestions = questions.value.length;
  const takenTime = (testduration.value * 60) - timeRemaining.value; // Calculate taken time in seconds
  const score = Math.round((correctAnswers / totalQuestions) * 100); // Percentage-based score

  try {
    const response = await axios.post('/submit-test', {
      user_id: localStorage.getItem('user_id'), // Replace with actual user ID
      test_id: testId,
      score: score,
      number_of_total_questions: totalQuestions,
      number_of_answred_questions: answeredQuestions,
      number_of_correct_answers: correctAnswers,
      taken_time_to_complete_the_test: takenTime,
      results: results
    });

    console.log("Test results saved:", response.data);
    showSummary(score, totalQuestions, answeredQuestions, correctAnswers, takenTime);
    router.push({ name: 'home' }); // Redirect to home page
  } catch (error) {
    console.error("Error saving test results:", error);
  }
};


// Fetch questions and test duration
const fetchQuestions = async () => {
  try {
    const response = await axios.get(`/tests/${testId}/questions`);
    console.log("API response:", response.data); // Debugging log
    testTitle.value = response.data.test_title;
    testduration.value = response.data.test_duration; // Set test duration from API

    questions.value = response.data.questions;
  } catch (error) {
    console.error("Error fetching questions:", error);
  } finally {
    loading.value = false;
  }
};

// Handle answer selection
const selectAnswer = (questionId, choiceId) => {
  selectedAnswers.value[questionId] = choiceId;
};

// Handle end exam


// Function to display the summary to the user
const showSummary = (score, totalQuestions, answeredQuestions, correctAnswers, takenTime) => {
  alert(`
    Test Summary:
    - Score: ${score}%
    - Total Questions: ${totalQuestions}
    - Answered Questions: ${answeredQuestions}
    - Correct Answers: ${correctAnswers}
    - Time Taken: ${Math.floor(takenTime / 60)} min ${takenTime % 60} sec
  `);
};

</script>

<style scoped>
/* Add custom styles if needed */
</style>
