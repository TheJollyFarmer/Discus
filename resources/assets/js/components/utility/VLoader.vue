<template>
  <div class="loader-wrapper">
    <div class="loader-bar"/>
  </div>
</template>

<script>
export default {
  name: "VLoader"
};
</script>

<style scoped>
.loader-wrapper {
  align-content: center;
  display: flex;
  justify-content: center;
  margin-top: 1em;
}

.loader-bar,
.loader-bar:before,
.loader-bar:after {
  background-color: rgba(215, 230, 240, 0.9);
  border: 1px solid rgb(215, 240, 230);
  box-sizing: content-box;
  content: " ";
  display: inline-block;
  height: 50px;
  margin-left: -5px;
  margin-right: -9px;
  position: relative;
  width: 20px;
  z-index: 100000;
}

.loader-bar {
  animation: loading-bar-main 0.8s cubic-bezier(0.4, 0.5, 0.6, 1) 0.2s infinite;
}

.loader-bar:before {
  animation: loading-bar 0.8s cubic-bezier(0.4, 0.5, 0.6, 1) infinite;
  left: -100%;
  top: -11px;
}

.loader-bar:after {
  animation: loading-bar 0.8s cubic-bezier(0.4, 0.5, 0.6, 1) 0.4s infinite;
  margin-top: 50%;
  right: -100%;
  top: -11px;
}

@keyframes loading-bar {
  from {
    background-color: rgba(0, 209, 178, 0.9);
    border: 1px solid rgb(0, 209, 178);
    transform: scaleY(1.4);
  }
}

@keyframes loading-bar-main {
  from {
    background-color: rgba(0, 209, 178, 0.9);
    border: 1px solid rgb(0, 209, 178);
    margin-top: -10px;
    padding-bottom: 10px;
    padding-top: 10px;
  }
}
</style>
