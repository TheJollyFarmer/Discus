<template>
  <div class="buttons">
    <v-button
      icon="reply"
      @onClick="setForm('commenting')"/>
    <v-button
      v-if="isThreadOwner"
      icon="edit"
      @onClick="setForm('editing')"/>
    <thread-subscribe-button @subscribe="subscribeEvent"/>
    <template v-if="isThreadOwner">
      <thread-lock-button @lock="lockEvent"/>
      <thread-pin-button @pin="pinEvent"/>
      <v-button
        icon="fire"
        class="is-danger"
        @onClick="deleteEvent"/>
    </template>
    <v-form-buttons 
      v-if="formActive"
      @submit="submitEvent" 
      @close="closeForm"/>
  </div>
</template>

<script>
import ThreadLockButton from "./ThreadLockButton";
import ThreadPinButton from "./ThreadPinButton";
import ThreadSubscribeButton from "./ThreadSubscribeButton";
import VButton from "../utility/VButton";
import VFormButtons from "./ThreadFormButtons";
import { mapActions, mapGetters, mapState } from "vuex";

export default {
  name: "ThreadButtons",

  components: {
    ThreadLockButton,
    ThreadPinButton,
    ThreadSubscribeButton,
    VButton,
    VFormButtons
  },

  computed: {
    ...mapGetters("auth", ["isThreadOwner"]),

    ...mapState("threads/thread", {
      formActive: state => state.formType
    })
  },

  methods: {
    ...mapActions({
      openModal: "openModal",
      setFormType: "threads/thread/setFormType",
      closeForm: "threads/thread/closeForm"
    }),

    setForm(type) {
      if (!this.formActive) {
        this.setFormType(type);
      }
    },

    submitEvent() {
      this.formActive === "editing"
        ? this.$emit("edit")
        : this.$emit("comment");
    },

    subscribeEvent() {
      this.$emit("subscribe");
    },

    lockEvent() {
      this.$emit("lock");
    },

    pinEvent() {
      this.$emit("pin");
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
