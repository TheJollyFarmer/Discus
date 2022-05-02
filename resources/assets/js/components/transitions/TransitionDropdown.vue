<script>
export default {
  name: "TransitionDropdown",

  functional: true,

  render(createElement, context) {
    const data = {
      props: {
        name: "dropdown"
      }
    };

    return createElement("transition", data, context.children);
  }
};
</script>

<style scoped>
.dropdown-enter-active,
.dropdown-leave-active {
  transform-origin: 50% -50px;
  will-change: transform, opacity;
}

.dropdown-enter-active {
  animation: rotate 250ms ease-in;
}

.dropdown-leave-active {
  animation: rotate 250ms ease-in reverse;
}

@keyframes rotate {
  from {
    transform: rotateX(-15deg);
    opacity: 0;
  }
  to {
    transform: rotateX(0deg);
    opacity: 1;
  }
}
</style>
