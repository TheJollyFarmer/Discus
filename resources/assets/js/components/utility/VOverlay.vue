<template>
  <transition 
    name="overlay-fade" 
    @after-enter="toggleContent(type)">
    <div 
      v-show="displayOverlay === type"
      class="modal is-active">
      <div 
        class="modal-background" 
        @click="toggleContent(type)"/>
      <slot/>
    </div>
  </transition>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
  name: "VOverlay",

  props: {
    type: {
      type: String,
      required: true
    }
  },

  computed: mapState(["displayOverlay"]),

  methods: mapActions(["toggleContent"])
};
</script>

<style scoped>
.overlay-fade-enter-active {
  animation: fade 0.25s ease-in;
}

.overlay-fade-leave-active {
  animation: fade 0.2s ease-out reverse;
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
