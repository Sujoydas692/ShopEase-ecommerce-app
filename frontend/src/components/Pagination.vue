<!-- components/Pagination.vue -->
<template>
  <div class="pagination" v-if="meta.last_page > 1">
    <!-- Previous Button -->
    <button 
      @click="goToPage(meta.current_page - 1)"
      :disabled="meta.current_page === 1"
      class="pagination-btn pagination-prev"
      :class="{ disabled: meta.current_page === 1 }"
    >
      &laquo; Prev
    </button>

    <!-- Page Numbers -->
    <template v-for="page in displayedPages" :key="page">
      <!-- First Page -->
      <button 
        v-if="page === 1 && shouldShowFirstPage"
        @click="goToPage(1)"
        class="pagination-btn"
        :class="{ active: meta.current_page === 1 }"
      >
        1
      </button>

      <!-- Ellipsis before current pages -->
      <span 
        v-if="page === 'ellipsis-start'"
        class="pagination-ellipsis"
      >
        ...
      </span>

      <!-- Current Pages -->
      <button 
        v-if="typeof page === 'number'"
        @click="goToPage(page)"
        class="pagination-btn"
        :class="{ active: meta.current_page === page }"
      >
        {{ page }}
      </button>

      <!-- Ellipsis after current pages -->
      <span 
        v-if="page === 'ellipsis-end'"
        class="pagination-ellipsis"
      >
        ...
      </span>

      <!-- Last Page -->
      <button 
        v-if="page === meta.last_page && shouldShowLastPage"
        @click="goToPage(meta.last_page)"
        class="pagination-btn"
        :class="{ active: meta.current_page === meta.last_page }"
      >
        {{ meta.last_page }}
      </button>
    </template>

    <!-- Next Button -->
    <button 
      @click="goToPage(meta.current_page + 1)"
      :disabled="meta.current_page === meta.last_page"
      class="pagination-btn pagination-next"
      :class="{ disabled: meta.current_page === meta.last_page }"
    >
      Next &raquo;
    </button>

    <!-- Page Info -->
    <div class="pagination-info">
      Showing {{ meta.from }}-{{ meta.to }} of {{ meta.total }} items
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  meta: {
    type: Object,
    required: true
  }
});

const emit = defineEmits(['page-changed']);

const goToPage = (page) => {
  if (page >= 1 && page <= props.meta.last_page) {
    emit('page-changed', page);
  }
};

// Calculate which pages to display
const displayedPages = computed(() => {
  const { current_page, last_page } = props.meta;
  const pages = [];
  const maxVisiblePages = 5;

  if (last_page <= 7) {
    // Show all pages if total pages are less than or equal to 7
    for (let i = 1; i <= last_page; i++) {
      pages.push(i);
    }
  } else {
    // Always show first page
    pages.push(1);

    // Calculate start and end of visible pages
    let start = Math.max(2, current_page - 1);
    let end = Math.min(last_page - 1, current_page + 1);

    // Adjust if we're at the beginning
    if (current_page <= 3) {
      end = 4;
    }

    // Adjust if we're at the end
    if (current_page >= last_page - 2) {
      start = last_page - 3;
    }

    // Add ellipsis after first page if needed
    if (start > 2) {
      pages.push('ellipsis-start');
    }

    // Add middle pages
    for (let i = start; i <= end; i++) {
      pages.push(i);
    }

    // Add ellipsis before last page if needed
    if (end < last_page - 1) {
      pages.push('ellipsis-end');
    }

    // Always show last page
    if (last_page > 1) {
      pages.push(last_page);
    }
  }

  return pages;
});

const shouldShowFirstPage = computed(() => {
  return !displayedPages.value.includes(1);
});

const shouldShowLastPage = computed(() => {
  return !displayedPages.value.includes(props.meta.last_page);
});
</script>

<style scoped>
.pagination {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  flex-wrap: wrap;
  margin: 20px 0;
}

.pagination-btn {
  padding: 8px 12px;
  border: 1px solid #ddd;
  background: white;
  color: #333;
  cursor: pointer;
  border-radius: 4px;
  transition: all 0.3s ease;
  min-width: 40px;
  text-align: center;
}

.pagination-btn:hover:not(.disabled) {
  background: #f0f0f0;
  border-color: #999;
}

.pagination-btn.active {
  background: #FF324D;
  color: white;
  border-color: #FF324D;
}

.pagination-btn.disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.pagination-ellipsis {
  padding: 8px 4px;
  color: #666;
}

.pagination-info {
  margin-left: 16px;
  color: #666;
  font-size: 14px;
}

/* Responsive */
@media (max-width: 768px) {
  .pagination {
    gap: 4px;
  }
  
  .pagination-btn {
    padding: 6px 8px;
    min-width: 36px;
    font-size: 14px;
  }
  
  .pagination-info {
    margin-left: 8px;
    font-size: 12px;
  }
}
</style>