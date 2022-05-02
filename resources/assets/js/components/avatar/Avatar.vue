<template>
  <form 
    v-if="canUpdate"
    class="avatar-form"
    method="POST" 
    enctype="multipart/form-data">
    <image-upload 
      name="avatar" 
      @loaded="onLoad"/>
  </form>
</template>

<script>
import ImageUpload from "./AvatarUpload.vue";
import axios from "axios";

export default {
  components: { ImageUpload },
  props: ["user", "auth"],

  computed: {
    canUpdate() {
      return this.user.id === this.auth.id;
    }
  },

  methods: {
    onLoad(avatar) {
      this.$emit("changed", avatar.src);
      this.persist(avatar.file);
    },

    persist(avatar) {
      let data = new FormData();
      data.append("avatar", avatar);
      axios
        .post(`/api/users/${this.user.name}/avatar`, data)
        .then(() => flash("Avatar uploaded!"));
    }
  }
};
</script>

<style scoped>
.avatar-form {
  height: 44px;
  width: 44px;
}
</style>
