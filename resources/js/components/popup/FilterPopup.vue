<template>
    <div v-if="isVisible" class="overlay fixed inset-0 bg-gray-800 bg-opacity-75 flex lg:items-center justify-end lg:justify-center" @click="close">
        <div class="bg-white p-5 lg:p-8 lg:rounded-lg shadow-lg max-w-md h-[100%] w-[65%] lg:h-[70%] lg:w-full relative" @click.stop>
            <div class="mb-5 mt-2 lg:mt-0 flex flex-row items-center justify-between">
                <p @click="close" class="block lg:hidden text-[#B38B60] text-xs font-bold font-['Inter'] leading-[28.80px]">Cancel</p>
                <p class="text-black text-xl lg:text-2xl font-bold lg:font-semibold font-['Inter'] leading-[28.80px]">FILTER</p>
                <p @click="clearAll" class="block lg:hidden text-[#B38B60] text-xs font-bold font-['Inter'] leading-[28.80px]">Clear all</p>
            </div>
            <div class="tag border-b border-gray-300 pb-5">
                <div class="tag_label flex justify-between mt-3 mb-2">
                    <div class="tag_label_name text-black-2 lg:font-semibold">Category</div>
                </div>
                <div class="tag_list">
                    <button
                        v-for="(kind, index) in listKind"
                        :key="kind.id"
                        @click="toggleKind(kind.id)"
                        :class="['text-[#4d2f19] inline-flex lg:h-[38px] justify-center items-center flex-shrink-0 rounded-full bg-[rgba(153,125,108,0.12)] p-[14px] m-[5px] h-[28px]',
                          { 'active_btn': filterSearch.kind.includes(kind.id) }]">
                        {{ kind.name }}
                    </button>
                </div>
            </div>
            <div class="tag">
                <div class="tag_label flex justify-between mt-3 mb-2">
                    <div class="tag_label_name text-black-2 lg:font-semibold">Tag</div>
                </div>
                <div class="tag_list">
                    <button
                        v-for="(tag, index) in listTag"
                        :key="tag.id"
                        @click="toggleTag(tag.id)"
                        :class="['text-[#4d2f19] inline-flex lg:h-[38px] justify-center items-center flex-shrink-0 rounded-full bg-[rgba(153,125,108,0.12)] p-[14px] m-[5px] h-[28px]',
                            { 'active_btn': filterSearch.tag.includes(tag.id) }]">
                        {{ tag.name }}
                    </button>
                </div>
            </div>
            <div class="filter_btn flex items-center justify-center absolute bottom-0 left-0 right-0 p-10 lg:p-0 bg-white lg:static lg:justify-end mt-5">
                <button @click="clearAll" class="hidden md:block bg-gray-300 text-gray-700 px-4 py-2 rounded text-black-2 ">Clear all</button>
                <button @click="close" class="bg-[#B38B60] text-[#f2f5f8] px-4 py-2 rounded-full inline-flex lg:h-[38px] justify-center items-center lg:flex-shrink-0 lg:p-[14px] lg:m-[5px] h-[28px] w-full lg:w-auto">Apply</button>
            </div>
        </div>
    </div>


</template>

<script setup>
import {reactive, ref, watch, computed} from 'vue';
import { defineProps, defineEmits } from 'vue';




const listTag= [
    {
        id: 't01',
        name: 'Sumner'
    },
    {
        id: 't02',
        name: 'Winter'
    },
    {
        id: 't03',
        name: 'Hot'
    },
    {
        id: 't04',
        name: 'Cold'
    },
    {
        id: 't05',
        name: 'Sweet'
    },
    {
        id: 't06',
        name: 'Sour'
    },
    {
        id: 't07',
        name: 'Cool'
    }
]

const listKind= [
    {
        id: 'k01',
        name: 'Bread'
    },
    {
        id: 'k02',
        name: 'Coffee'
    },
    {
        id: 'k03',
        name: 'Tea'
    },
    {
        id: 'k04',
        name: 'Topping'
    },
    {
        id: 't05',
        name: 'Sweet'
    }
]

const props = defineProps({
    isVisible: {
        type: Boolean,
        required: true
    },
    searchText: String,
});

const emit = defineEmits();
const close = () => {
    emit('closePopup');
};

// Reactive object for filterSearch
const filterSearch = ref({
    kind: [],
    tag: [],
    searchText:props.searchText
});

// Toggle kind selection
const toggleKind = (id) => {
    const index = filterSearch.value.kind.indexOf(id);
    if (index > -1) {
        filterSearch.value.kind.splice(index, 1); // Remove from 'kind'
    } else {
        filterSearch.value.kind.push(id); // Add to 'kind'
    }
};

// Toggle tag selection
const toggleTag = (id) => {
    const index = filterSearch.value.tag.indexOf(id);
    if (index > -1) {
        filterSearch.value.tag.splice(index, 1); // Remove from 'tag'
    } else {
        filterSearch.value.tag.push(id); // Add to 'tag'
    }
};
const clearAll = () => {
    // Xóa hết dữ liệu trong filterSearch
    filterSearch.value.kind = [];
    filterSearch.value.tag = [];

    // Xóa class 'active_btn' khỏi tất cả các nút
    const activeBtns = document.querySelectorAll('.active_btn');
    activeBtns.forEach(btn => {
        btn.classList.remove('active_btn');
    });
};
// Computed để theo dõi sự thay đổi của props.searchText
const computedSearchText = computed(() => {
    return props.searchText;
});

// Cập nhật filterSearch.searchText khi computedSearchText thay đổi
filterSearch.value.searchText = computedSearchText.value;

watch(() => props.searchText, (newValue) => {
    filterSearch.value.searchText = newValue;
    console.log(filterSearch)

});


</script>

<style scoped>
.active_btn {
    display: inline-flex;
    height: 38px;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    border-radius: 50px;
    color: #f2f5f8;
    background: #B38B60;
    padding: 14px;
    margin: 5px;
}
@media (max-width: 700px) {
    .active_btn {
        height: 28px;
    }
}

</style>
