<template>
    <div>
      <h2>Add Work Calendar</h2>
      <form @submit.prevent="submitForm">
        <div class="form-check">
          <input type="checkbox" v-model="halfDayOption" id="halfDayOption">
          <label for="halfDayOption">Half working day & half weekend</label>
        </div>
  
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Day</th>
              <th v-for="col in columns" :key="col">{{ col }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(day, index) in days" :key="day">
              <td>{{ day }}</td>
              <td v-for="col in columns" :key="col">
                <div class="d-flex align-items-center">
             
                  <input v-if="col === 'All'" 
                         type="checkbox" 
                         :checked="allChecked(index)" 
                         @change="toggleAll(index, $event.target.checked)" />
  
                  <input v-else 
                         type="checkbox" 
                         v-model="formData[index][col].checked" 
                         @change="checkIfAllUnchecked(index)" />
                  
                 
                  <select v-if="halfDayOption && col !== 'All'" 
                          v-model="formData[index][col].selected" 
                          class="form-control ml-2">
                    <option value="full">Full Day</option>
                    <option value="first-half">1st Half</option>
                    <option value="second-half">2nd Half</option>
                  </select>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
  
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  const columns = ['All', '1st', '2nd', '3rd', '4th', '5th'];
  
  const halfDayOption = ref(false);
  
  const formData = ref(days.map(() => {
    return columns.reduce((acc, col) => {
      acc[col] = { checked: false, selected: 'full' }; 
      return acc;
    }, {});
  }));
  

  const allChecked = (rowIndex) => {
    return columns.slice(1).every(col => formData.value[rowIndex][col].checked);
  };
  
  
  const toggleAll = (rowIndex, isChecked) => {
    columns.slice(1).forEach(col => {
      formData.value[rowIndex][col].checked = isChecked;
    });
  };
  

  const checkIfAllUnchecked = (rowIndex) => {
    const allCheckedStatus = allChecked(rowIndex);
    if (!allCheckedStatus) {
   
      formData.value[rowIndex]['All'].checked = false;
    }
  };
  
//   function submitForm() {
//     // Handle form submission
//     console.log('Form submitted', formData.value, halfDayOption.value);
//   }
  </script>
  
  <style scoped>
.table {
  width: 100%;
  border-collapse: collapse;
  
}

.table th, .table td {
  padding: 15px; /* Increased padding for better spacing */
  text-align: center;
  border: 1px solid #dee2e6;
  vertical-align: middle; /* Align content in the center of the cell */
}

.table thead th {
  background-color: #f8f9fa;
  font-weight: bold;
}

.d-flex {
  display: flex;
  align-items: center;
  justify-content: center; /* Ensure checkboxes and selects are centered */
}

.ml-2 {
  margin-left: 10px;
}

.form-check input[type="checkbox"] {
  margin-right: 10px; /* More space between the checkbox and the label */
}

.form-check label {
  margin-bottom: 0;
}

select.form-control {
  width: 150px; /* Set fixed width for consistency */
  max-width: 150px;
  height: 36px; /* Match the height of the input elements */
  padding: 5px;
  
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
  padding: 10px 20px;
  font-size: 16px;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #004085;
}

.table-bordered td, .table-bordered th {
  border: 2px solid #ddd; /* Thicker borders for a more defined look */
}

input[type="checkbox"] {
  width: 20px;
  height: 20px;
}

</style>
