<script>
export default {
  name: "TransitionFade",

  functional: true,

  props: {
    duration: {
      type: Number,
      required: false,
      default: 0.5
    }
  },

  render(createElement, context) {
    const data = {
      props: {
        appear: true,
        name: "fade",
        mode: "out-in"
      },

      on: {
        beforeEnter(el) {
          el.style.animationDuration = `${context.props.duration}s`;
        },

        beforeLeave(el) {
          el.style.animationDuration = `${context.props.duration}s`;
        }
      }
    };

    return createElement("transition", data, context.children);
  }
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  animation-name: fade;
  animation-timing-function: ease-in-out;
}

.fade-leave-active {
  animation-direction: reverse;
}

@keyframes fade {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}
</style>
