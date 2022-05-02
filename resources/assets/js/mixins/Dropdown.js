export default {
  data() {
    return {
      isActive: false
    };
  },

  mounted() {
    document.addEventListener("click", this.closeDropdown);
  },

  beforeDestroy() {
    document.removeEventListener("click", this.closeDropdown);
  },

  methods: {
    toggleDropdown() {
      this.isActive = !this.isActive;
    },

    closeDropdown(event) {
      if (!this.$el.contains(event.target)) {
        this.isActive = false;
      }
    }
  }
};
