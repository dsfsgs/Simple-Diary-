<template>
    <div class="card">
        <div class="card-header">All Diaries</div>
        <div class="card-body">
            <!-- Create Diary Form -->
            <div class="create-diary">
                <h3>Create New Diary</h3>
                <input v-model="newDiary.title" placeholder="Title" class="edit-input" />
                <textarea v-model="newDiary.description" placeholder="Description" class="edit-textarea"></textarea>
                <input type="file" @change="onNewFileChange" class="edit-input" />
                <button @click="createDiary" class="save-button">Create</button>
                <hr>
            </div>
            <!-- Diary List -->
            <div v-for="diary in diaries" :key="diary.id" class="diary-item">
                <div class="diary-header">
                    <h3 v-if="!diary.isEditing">{{ diary.title }}</h3>
                    <input v-else v-model="diary.title" class="edit-input" />
                    <div class="meatball-menu">
                        <button @click="toggleMenu(diary.id)">⋮</button>
                        <div v-if="diary.showMenu" class="menu-options">
                            <button @click="editDiary(diary.id)">Edit</button>
                            <button @click="deleteDiary(diary.id)">Delete</button>
                        </div>
                    </div>
                </div>
                <p v-if="!diary.isEditing">{{ diary.description }}</p>
                <textarea v-else v-model="diary.description" class="edit-textarea"></textarea>
                <div class="image-container">
                    <img v-if="!diary.isEditing" :src="diary.image" alt="Diary Image" class="img-fluid centered-image">
                </div>
                <input v-if="diary.isEditing" type="file" @change="onFileChange($event, diary.id)" class="edit-input" />
                <br>
                <small v-if="!diary.isEditing">{{ diary.timestamp }}</small>
                <button v-if="diary.isEditing" @click="saveDiary(diary.id)" class="save-button">Save</button>
                <hr> <!-- Separation line added here -->
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            diaries: [
                {
                    id: 1,
                    title: 'Diary 1',
                    description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    image: '/img/image.png',
                    timestamp: '2025-03-14 10:00:00',
                    isEditing: false,
                    showMenu: false,
                },
                {
                    id: 2,
                    title: 'Diary 2',
                    description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                    image: '/img/image.png',
                    timestamp: '2025-03-14 11:00:00',
                    isEditing: false,
                    showMenu: false,
                },
            ],
            newDiary: {
                title: '',
                description: '',
                image: '',
            },
        };
    },
    methods: {
        fetchDiaries() {
            axios.get('/api/diaries')
                .then(response => {
                    if (response.data.length > 0) {
                        this.diaries = response.data;
                    }
                })
                .catch(error => {
                    console.error('Error fetching diaries:', error);
                });
        },
        createDiary() {
            axios.post('/api/diaries', this.newDiary)
                .then(response => {
                    this.diaries.push(response.data);
                    this.newDiary = { title: '', description: '', image: '' }; // Reset the form
                    console.log(`New diary with id: ${response.data.id} has been created`);
                })
                .catch(error => {
                    console.error('Error creating diary:', error);
                });
        },
        toggleMenu(id) {
            this.diaries = this.diaries.map(diary =>
                diary.id === id ? { ...diary, showMenu: !diary.showMenu } : diary
            );
        },
        editDiary(id) {
            this.diaries = this.diaries.map(diary =>
                diary.id === id ? { ...diary, isEditing: true, showMenu: false } : diary
            );
        },
        saveDiary(id) {
            const diary = this.diaries.find(diary => diary.id === id);
            axios.put(`/api/diaries/${id}`, diary)
                .then(response => {
                    this.diaries = this.diaries.map(diary =>
                        diary.id === id ? { ...response.data, isEditing: false } : diary
                    );
                    console.log(`Diary with id: ${id} has been updated`);
                })
                .catch(error => {
                    console.error('Error updating diary:', error);
                });
        },
        deleteDiary(id) {
            axios.delete(`/api/diaries/${id}`)
                .then(() => {
                    this.diaries = this.diaries.filter(diary => diary.id !== id);
                    console.log(`Diary with id: ${id} has been deleted`);
                })
                .catch(error => {
                    console.error('Error deleting diary:', error);
                });
        },
        onFileChange(event, id) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const imageUrl = e.target.result;
                    this.diaries = this.diaries.map(diary =>
                        diary.id === id ? { ...diary, image: imageUrl } : diary
                    );
                };
                reader.readAsDataURL(file);
            }
        },
        onNewFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.newDiary.image = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
    },
    mounted() {
        this.fetchDiaries();
    }
};
</script>

<style scoped>
.card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}
.card-header {
    background-color: #6C63FF;
    color: #fff;
    padding: 16px;
    font-size: 20px;
    text-align: center;
}
.card-body {
    padding: 16px;
}
.create-diary {
    margin-bottom: 16px;
    max-width: 600px; /* Adjust the width of the create diary form */
    margin-left: auto;
    margin-right: auto; /* Center the form */
    padding-left: 10%;
    padding-right: 10%; /* Add padding */
}
.diary-item {
    margin-bottom: 16px;
    position: relative;
}
.diary-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.meatball-menu {
    position: relative;
}
.meatball-menu button {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
}
.menu-options {
    position: absolute;
    right: 0;
    background: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.517);
    border-radius: 8px;
    overflow: hidden;
}
.menu-options button {
    display: block;
    width: 100%;
    padding: 4px 8px;
    background: none;
    border: none;
    text-align: left;
    cursor: pointer;
    font-size: 12px; /* Reduced font size */
}
.menu-options button:hover {
    background: #3d214f;
    color: white;
}
.image-container {
    display: flex;
    justify-content: center;
    align-items: center;
}
.centered-image {
    max-width: 50%;
    height: auto;
    border-radius: 8px;
}
.edit-input {
    width: 100%;
    padding: 8px;
    margin-bottom: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.edit-textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.save-button {
    background-color: #6C63FF;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 8px; /* Added margin-top for spacing */
}
.save-button:hover {
    background-color: #5a52d1;
}
</style>
