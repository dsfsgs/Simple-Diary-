<template>
    <div class="card">
        <div class="card-left">
            <h2>Personal Diary</h2>
        </div>
        <div class="card-right">
            <img src="/img/image.png" alt="Personal Diary">
        </div>
    </div>
</template>

<script>
export default {
    name: 'PersonalDiaryCard',
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');

.card {
    display: flex;
    max-width: 900px;
    margin: auto;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}
.card-left {
    flex: 1;
    background-color: #6C63FF;
    color: #fff;
    padding: 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.card-left h2 {
    font-size: 36px;
    margin-bottom: 20px;
    font-family: 'Pacifico', cursive;
}
.card-right {
    flex: 1;
    padding: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.card-right img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}
</style>
