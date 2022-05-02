<template>
  <div class="buttons">
    <v-button
      v-if="depth <= 2"
      icon="reply"
      @onClick="formEvent('reply')"/>
    <template v-if="isCreatedBy(comment)">
      <v-button
        icon="edit"
        @onClick="formEvent('edit')"/>
      <v-button
        v-if="hasNoChildren"
        icon="eraser"
        class="is-danger"
        @onClick="deleteEvent"/>
    </template>
    <v-form-buttons 
      v-if="formActive" 
      @submit="submitEvent"
      @close="cancelEvent"/>
  </div>
</template>

<script>
import VButton from "../utility/VButton";
import VFormButtons from "../thread/ThreadFormButtons";
import { mapGetters } from "vuex";

export default {
  name: "CommentButtons",

  components: { VFormButtons, VButton },

  props: {
    comment: {
      type: Number,
      required: true
    },

    depth: {
      type: Number,
      required: true
    },

    children: {
      type: Array,
      required: true
    }
  },

  data() {
    return {
      formActive: false
    };
  },

  computed: {
    ...mapGetters("auth", ["isCreatedBy"]),

    hasNoChildren() {
      return !this.children.length;
    }
  },

  methods: {
    formEvent(type) {
      if (!this.formActive) {
        this.formActive = true;

        this.$emit("form", type);
      }
    },

    cancelEvent() {
      this.formActive = false;

      this.$emit("cancel");
    },

    submitEvent() {
      this.$emit("submit", done => {
        if (done) {
          this.formActive = false;
        }
      });
    },

    deleteEvent() {
      this.$emit("delete");
    }
  }
};
</script>

<style lang="scss" scoped>
.buttons {
  margin-bottom: 0.25rem;
}
</style>
