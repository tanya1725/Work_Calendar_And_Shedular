<template>
  <div>
    <input v-model="text1" type="text" placeholder="Enter text 1" />
    <input v-model="text2" type="text" placeholder="Enter text 2" />
    <button @click="addLabel" class="add">Add</button>

    <div v-for="(label, index) in labels" :key="index" class="label">
      <span>{{ label.text1 }}</span>
      <span v-if="!isEditing[index]">[{{ label.text2 }}]</span>
      <input v-else v-model="tempText2[index]" type="text" placeholder="Edit text 2" />
      <button v-if="!isEditing[index]" @click="startEdit(index)" class="edit">Edit</button>
      <button v-else @click="saveEdit(index)" class="save">Save</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const text1 = ref('');
const text2 = ref('');
const labels = ref([]);
const isEditing = ref([]); // Tracks which label is being edited
const tempText2 = ref([]); // Temporary storage for edited text2

const addLabel = () => {
  if (text1.value && text2.value) {
    labels.value.push({ text1: text1.value, text2: text2.value });
    text1.value = '';
    text2.value = '';
  } else {
    alert('Please enter text in both fields');
  }
};

const startEdit = (index) => {
  tempText2.value[index] = labels.value[index].text2; // Load the current text2 value into tempText2 for editing
  isEditing.value[index] = true; // Set the index to be in editing mode
};

const saveEdit = (index) => {
  if (tempText2.value[index]) {
    labels.value[index].text2 = tempText2.value[index]; // Update only text2
    tempText2.value[index] = '';
    isEditing.value[index] = false; // Exit editing mode
  } else {
    alert('Please enter a value for Text 2');
  }
};
</script>

<style scoped>
.label {
  margin-top: 10px;
  font-size: 16px;
  background-color: aquamarine;
  width: 500px;
  height: 50px;
  display: flex;
  align-items: center;
  /* justify-content: space-between; */
  padding: 0 10px;
}
.add {
  background-color: aquamarine;
}
.edit, .save {
  background-color: lightcoral;
  border: none;
  color: white;
  padding: 5px 10px;
  cursor: pointer;
}
</style>
