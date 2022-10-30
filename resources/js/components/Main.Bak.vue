<template>
  <main class="main-section">
    <div class="main-content">
      <i class="bx bx-menu"></i>
      <span class="text">Drop Down Sidebar</span>
    </div>
  </main>
</template>

<style scoped>
.main-section {
  position: relative;
  background: #e4e9f7;
  height: 100vh;
  left: 260px;
  width: calc(100% - 260px);
  transition: all 0.5s ease;
}
.main-section .main-content {
  height: 60px;
  display: flex;
  align-items: center;
}
.main-section .main-content .bx-menu,
.main-section .main-content .text {
  color: #11101d;
  font-size: 35px;
}
.main-section .main-content .bx-menu {
  margin: 0 15px;
  cursor: pointer;
}
.main-section .main-content .text {
  font-size: 26px;
  font-weight: 600;
}
@media (max-width: 400px) {
  .main-section {
    left: 78px;
    width: calc(100% - 78px);
    z-index: 100;
  }
}
</style>