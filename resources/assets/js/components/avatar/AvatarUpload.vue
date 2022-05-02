<template>
  <div class="avatar-upload">
    <label 
      for="file" 
      class="button is-primary">
      <v-favicon icon="image"/>
    </label>
    <input 
      id="file" 
      class="hiddenInput"
      width="0" 
      type="file" 
      accept="image/*" 
      @change="onChange">
  </div>
</template>

<script>
import VFavicon from "../utility/VFavicon";

export default {
  name: "AvatarUpload",

  components: { VFavicon },

  methods: {
    onChange(e) {
      if (e.target.files.length) {
        let file = e.target.files[0];
        let reader = new FileReader();

        reader.readAsDataURL(file);

        reader.onload = e => {
          let src = e.target.result;

          this.$emit("loaded", { src, file });
        };
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.avatar-upload {
  label {
    color: white;
  }
  input {
    height: 0;
    visibility: hidden;
    width: 0;
  }
}
</style>
