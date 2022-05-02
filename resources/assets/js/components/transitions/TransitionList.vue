<script>
export default {
  name: "TransitionList",

  functional: true,

  props: {
    duration: {
      type: Number,
      required: false,
      default: 0.5
    },

    hasData: {
      type: Boolean,
      required: false,
      default: true
    },

    tag: {
      type: String,
      required: false,
      default: "div"
    }
  },

  render(createElement, context) {
    const data = {
      props: {
        name: "list-transition",
        tag: context.props.tag
      },

      class: "is-relative",

      on: {
        beforeEnter(el) {
          el.style.transitionDuration = `${context.props.duration}s`;
        },

        beforeLeave(el) {
          if (context.props.hasData) {
            el.style.position = "absolute";
          }

          el.style.transitionDuration = `${context.props.duration}s`;
        }
      }
    };

    return createElement("transition-group", data, context.children);
  }
};
</script>

<style>
.list-transition-enter-active,
.list-transition-leave-active,
.list-transition-move {
  transition: 500ms cubic-bezier(0.59, 0.12, 0.34, 0.95);
  transition-property: background-color, opacity, transform;
}

.list-transition-enter {
  opacity: 0;
  transform: translateX(50px) scaleY(0.5);
}

.list-transition-enter-to {
  opacity: 1;
  transform: translateX(0) scaleY(1);
}

.list-transition-leave-active {
  min-height: 1em;
  margin-bottom: 1em;
  width: 100%;
}

.list-transition-leave-to {
  opacity: 0;
  transform: scaleY(0);
  transform-origin: center top;
}
</style>
