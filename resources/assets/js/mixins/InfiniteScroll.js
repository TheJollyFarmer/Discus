export default {
  props: {
    infiniteScroll: {
      type: Boolean,
      required: false,
      default: true
    }
  },

  mounted() {
    if (this.infiniteScroll) {
      this.addScrollEvent();
    }
  },

  methods: {
    addScrollEvent() {
      window.onscroll = () => {
        let offset = document.documentElement.scrollTop + window.innerHeight;
        let offsetMax = document.documentElement.offsetHeight;

        if (offset === offsetMax) {
          this.$emit("fetch");
        }
      };
    }
  }
};
