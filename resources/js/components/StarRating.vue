<template>
    <div class="flex items-center">
    <span
        v-for="star in maxRating"
        :key="star"
        class="cursor-pointer"
        @click="setRating(star)"
        @mouseover="hoverRating(star)"
        @mouseleave="resetRating"
    >
      <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6"
          :class="getStarClass(star)"
          viewBox="0 0 20 20"
          fill="currentColor"
      >
        <path
            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
        />
      </svg>
    </span>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

// Define props and emits for v-model
const props = defineProps({
    modelValue: {
        type: Number,
        default: 0,
    },
    maxRating: {
        type: Number,
        default: 5,
    },
});

const emit = defineEmits(['update:modelValue']);

// Internal state for hover and rating
const hover = ref(0);

// Sync the internal rating with the parent's modelValue
const rating = ref(props.modelValue);

// Watch for changes in modelValue and update the internal rating
watch(
    () => props.modelValue,
    (newValue) => {
        rating.value = newValue;
    }
);

// Set the rating when a star is clicked
const setRating = (star) => {
    rating.value = star;
    emit('update:modelValue', star); // Emit the new rating to the parent
};

// Update hover state when hovering over stars
const hoverRating = (star) => {
    hover.value = star;
};

// Reset hover state when mouse leaves the stars
const resetRating = () => {
    hover.value = 0;
};

// Determine the class for each star
const getStarClass = (star) => {
    if (star <= (hover.value || rating.value)) {
        return 'text-yellow-500'; // Filled yellow star
    } else {
        return 'text-gray-300'; // Empty gray star
    }
};
</script>

<style scoped>
/* Add hover effect for better UX */
.cursor-pointer:hover svg {
    transform: scale(1.1);
    transition: transform 0.2s ease-in-out;
}
</style>
