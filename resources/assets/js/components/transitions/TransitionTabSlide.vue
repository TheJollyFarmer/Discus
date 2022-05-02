<script>
export default {
  name: "TransitionTabSlide",

  functional: true,

  props: {
    type: {
      type: String,
      required: true
    }
  },

  render(createElement, context) {
    const data = {
      props: {
        name: `slide-${context.props.type}`
      }
    };

    return createElement("transition", data, context.children);
  }
};
</script>

<style scoped>
.slide-single-enter-active,
.slide-next-enter-active,
.slide-next-leave-active,
.slide-prev-enter-active,
.slide-prev-leave-active {
  transition: transform 0.3s ease-in-out;
}

.slide-single-leave-to,
.slide-prev-leave-to,
.slide-single-enter,
.slide-next-enter {
  position: absolute;
  transform: translate3d(-100%, 0, 0);
  width: 100%;
}

.slide-prev-enter,
.slide-single-enter,
.slide-next-leave-to,
.slide-single-leave-to {
  position: absolute;
  transform: translate3d(100%, 0, 0);
  width: 100%;
}
</style>
