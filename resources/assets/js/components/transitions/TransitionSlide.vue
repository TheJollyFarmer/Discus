<script>
export default {
  name: "TransitionSlide",

  functional: true,

  render(createElement, context) {
    const data = {
      props: {
        name: "slide"
      }
    };

    return createElement("transition", data, context.children);
  }
};
</script>

<style scoped>
.slide-enter-active {
  animation: slide-in 0.3s ease;
}

.slide-leave-active {
  animation: slide-out 0.3s ease;
}

@keyframes slide-in {
  from {
    transform: translate3d(100%, 0, 0);
  }
  to {
    transform: translate3d(0, 0, 0);
  }
}

@keyframes slide-out {
  from {
    transform: translate3d(0, 0, 0);
  }
  to {
    transform: translate3d(-100%, 0, 0);
  }
}
</style>
