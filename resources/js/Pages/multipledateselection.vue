<template>
  <div class="scheduler-container">
    <div class="scheduler-header">
      <button @click="navigateMonth('prev')">&lt;</button>
      <span class="current-month">{{ currentMonth }}</span>
      <button @click="navigateMonth('next')">&gt;</button>
    </div>

    <DxScheduler
      ref="schedulerRef"
      :data-source="appointments"
      time-zone="America/Los_Angeles"
      :views="views"
      :current-view="currentView"
      :current-date="currentDate"
      :start-day-hour="8"
      :end-day-hour="18"
      :height="'calc(100vh - 50px)'"
      :show-all-day-panel="true"
      :first-day-of-week="1"
      :max-zoom-level="0"
      :cell-width="150"
      :cell-height="100"
      :show-navigation-buttons="false"
      @cellClick="cellclicked"
    >
      <template #appointment="{ itemData }">
        <div class="dx-scheduler-appointment">
          <div class="dx-scheduler-appointment-title">
            {{ itemData.text }}
          </div>
          <div class="dx-scheduler-appointment-details">
          </div>
        </div>
      </template>
    </DxScheduler>
  </div>
</template>

<script>
import { DxScheduler } from 'devextreme-vue/scheduler';
import { ref, computed, watch, onMounted } from 'vue';

export default {
  components: {
    DxScheduler,
  },
  setup() {
    const schedulerRef = ref(null);
    const currentDate = ref(new Date(2024, 3, 27));
    const selectedCells = ref([]);

    const currentMonth = computed(() => {
      const months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
      ];
      return `${months[currentDate.value.getMonth()]} ${currentDate.value.getFullYear()}`;
    });

    const navigateMonth = (direction) => {
      const newDate = new Date(currentDate.value);
      if (direction === 'prev') {
        newDate.setMonth(newDate.getMonth() - 1);
      } else if (direction === 'next') {
        newDate.setMonth(newDate.getMonth() + 1);
      }
      currentDate.value = newDate;

      if (schedulerRef.value && schedulerRef.value.instance) {
        schedulerRef.value.instance.option('currentDate', newDate);
      }
    };

    const cellclicked = (e) => {
  const isCtrlPressed = e.event.ctrlKey;

  if (isCtrlPressed) {

    selectedCells.value.push(e.cellElement);
    selectedCells.value.forEach((cell) => {
      cell.classList.add('selected-cell');
    });
  } else {

    selectedCells.value.forEach((cell) => {
      cell.classList.remove('selected-cell');
    });

 
    selectedCells.value = [];
    selectedCells.value.push(e.cellElement);

    e.cellElement.classList.add('selected-cell');
  }
};


    watch(currentDate, (newDate) => {
      if (schedulerRef.value && schedulerRef.value.instance) {
        schedulerRef.value.instance.option('currentDate', newDate);
      }
    });

    onMounted(() => {
      if (schedulerRef.value && schedulerRef.value.instance) {
        schedulerRef.value.instance.option('currentDate', currentDate.value);
      }
    });

    return {
      schedulerRef,
      currentDate,
      currentMonth,
      navigateMonth,
      cellclicked,
    };
  },
  data() {
    return {
      views: ['month'],
      currentView: 'month',
      appointments: [
        {
          startDate: new Date(2024, 3, 27, 9, 0),
          endDate: new Date(2024, 3, 27, 10, 0),
          text: 'Web Design Meeting',
        },
        // Add more appointments here
      ],
    };
  },
};
</script>

<style>
.scheduler-container {
  height: 100vh;
  width: 100vw;
  display: flex;
  flex-direction: column;
}

.scheduler-header {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 10px;
  background-color: #f5f5f5;
  border-bottom: 1px solid #ccc;
}

.scheduler-header button {
  font-size: 18px;
  border: none;
  background: none;
  cursor: pointer;
}

.current-month {
  font-size: 18px;
  font-weight: bold;
  margin: 0 20px;
}

.dx-scheduler-header-panel-cell {
  text-align: center;
  font-weight: bold;
  padding-right: 200px;
}

.dx-scheduler-date-table-cell {
  text-align: left;
  padding-right: 200px;
  padding-bottom: 77px;
  border: 1px solid #ccc;
}

.dx-scheduler-appointment {
  background-color: #1e90ff;
  color: white;
  border-radius: 5px;
  padding: 5px;
}

.dx-scheduler-appointment-title {
  font-size: 12px;
  font-weight: bold;
}

.dx-scheduler-appointment-details {
  font-size: 10px;
  color: #999;
}

.selected-cell {
  background-color: rgb(72, 133, 148);
  opacity: 50%;
  color: white; /* Optional: If you want to change text color too */
}
</style>