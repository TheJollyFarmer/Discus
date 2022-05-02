<template>
  <v-scroll
    :options="options()"
    class="scroll-content"
    @infiniteScroll="infiniteScroll"
    @created="goToBottom">
    <v-error
      v-show="hasNoData"
      :text="'You appear to have no ' + label"/>
    <slot v-if="!isInfiniteScrollTop"/>
    <v-error
      v-show="hasFetchedAllData"
      :text="'You have retrieved all ' + label "/>
    <v-loader v-if="progress"/>
    <slot v-if="isInfiniteScrollTop"/>
  </v-scroll>
</template>

<script>
import debounce from "lodash/throttle";
import VError from "./VError";
import VLoader from "./VLoader";
import VScroll from "./VScroll";
import { mapState } from "vuex";
import { getPath } from "../../utils/helpers";

export default {
  name: "VDataScroll",

  components: {
    VError,
    VLoader,
    VScroll
  },

  props: {
    data: {
      type: Number,
      required: true
    },

    label: {
      type: String,
      required: true
    },

    model: {
      type: String,
      required: false,
      default: ""
    },

    isInfinite: {
      type: Boolean,
      required: false,
      default: true
    },

    isInfiniteScrollTop: {
      type: Boolean,
      required: false,
      default: false
    }
  },

  computed: {
    ...mapState({
      completed(state) {
        return getPath(state, this.model).completed;
      },

      progress(state) {
        return getPath(state, this.model).progress;
      }
    }),

    hasNoData() {
      return !this.data && !this.progress;
    },

    hasFetchedAllData() {
      return this.data && this.completed;
    }
  },

  methods: {
    goToBottom(instance) {
      let timer = setInterval(() => {
        if (this.data && this.isInfiniteScrollTop) {
          instance.scroll({ y: "100%" });

          clearInterval(timer);
        }
      }, 100);
    },

    infiniteScroll() {
      this.$emit("infiniteScroll");
    },

    options() {
      let self = this;

      return {
        callbacks: {
          onContentSizeChanged() {
            if (self.isInfiniteScrollTop) {
              if (this.scroll().position.y >= 1) this.scroll({ y: "100%" });
            }
          },

          onScroll: debounce(function() {
            if (self.isInfinite) {
              let scroll = this.scroll();
              let scrollPosition = scroll.position.y;
              let isTop = !!(scrollPosition === 0 && scroll.max.y > 1);
              let isBottom = scrollPosition === scroll.max.y;

              if (self.isInfiniteScrollTop) {
                if (isTop) self.infiniteScroll();
              } else if (isBottom) self.infiniteScroll();
            }
          }, 500)
        }
      };
    }
  }
};
</script>

<style lang="scss" scoped>
.scroll-content {
  flex: 1;
  overflow: hidden;
  .is-relative {
    height: 100%;
    width: 100%;
  }
}
</style>
