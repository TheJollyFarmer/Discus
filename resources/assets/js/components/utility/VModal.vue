<template>
  <v-overlay type="modal">
    <transition 
      name="modal-fade"
      @after-leave="closeOverlay">
      <div
        v-show="displayModal"
        class="modal-content"
        role="dialog">
        <transition 
          name="content-fade"
          mode="out-in">
          <div 
            :key="modal" 
            class="box">
            <v-avatar
              v-if="modalImage"
              :path="`/storage/avatars/${modalImage}.png`"
              class="modal-img"
              dimension="96"
              circle/>
            <div :class="{ 'modal-margin': modalImage }">
              <slot/>
            </div>
          </div>
        </transition>
      </div>
    </transition>
  </v-overlay>
</template>

<script>
import VAvatar from "./VAvatar";
import VOverlay from "./VOverlay";
import { mapActions, mapState } from "vuex";

export default {
  name: "VModal",

  components: { VAvatar, VOverlay },

  computed: mapState(["displayModal", "modalImage", "modal"]),

  methods: mapActions(["closeOverlay"])
};
</script>

<style scoped>
.modal-content {
  overflow: initial;
  width: auto;
}

.modal-img {
  border-radius: 50%;
  position: relative;
  top: -70px;
}

.modal-margin {
  margin-top: -50px;
}

.modal-fade-enter,
.modal-fade-leave-to {
  opacity: 0;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s ease;
}

.content-fade-enter,
.content-fade-leave-to {
  opacity: 0;
}

.content-fade-enter-active,
.content-fade-leave-active {
  transition: opacity 0.3s ease;
}
</style>
