<template>
  <v-tag
    rounded
    class="typing">
    <span>.</span><span>.</span><span>.</span>
  </v-tag>
</template>

<script>
import VTag from "./VTag";

export default {
  name: "VTypingIndicator",

  components: { VTag },

  props: {
    group: {
      type: Number,
      required: true
    }
  },

  data() {
    return {
      typing: false
    };
  },

  created() {
    this.listenForTyping();
  },

  methods: {
    listenForTyping() {
      this.$echo.private("chat." + this.group).listenForWhisper("typing", e => {
        this.$emit("typing", e.typing);

        setTimeout(() => {
          this.$emit("typing", false);
        }, 10000);
      });
    }
  }
};
</script>

<style scoped>
.typing {
  align-items: flex-start;
  font-size: large;
}

.typing span {
  animation-name: blink;
  animation-duration: 1.4s;
  animation-iteration-count: infinite;
  animation-fill-mode: both;
}

.typing span:nth-child(2) {
  animation-delay: 0.2s;
}

.typing span:nth-child(3) {
  animation-delay: 0.4s;
}

@keyframes blink {
  0% {
    opacity: 0.2;
  }

  20% {
    opacity: 1;
  }

  100% {
    opacity: 0.2;
  }
}
</style>
