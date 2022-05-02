<template>
  <div 
    v-show="show" 
    :class="'alert-'+result.toLowerCase()" 
    class="alert alert-flash" 
    role="alert">
    <p><strong>{{ result }}!</strong> {{ body }}..</p>
    <p>{{ type }}</p>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      required: true
    }
  },

  data() {
    return {
      body: this.message,
      result: "Danger",
      type: "",
      show: false
    };
  },

  created() {
    if (this.message) {
      this.flash();
    }

    // window.events.$on("flash", data => {
    //   this.flash(data);
    // });
  },

  methods: {
    flash(data) {
      if (data) {
        this.type = data.type;
        this.result = data.result;
        this.body = data.message;
      }
      this.show = true;
      this.hide();
    },

    hide() {
      setTimeout(() => {
        this.show = false;
      }, 3000);
    }
  }
};
</script>

<style>
.alert-flash {
  position: fixed;
  right: 2em;
  bottom: 2em;
}
</style>
