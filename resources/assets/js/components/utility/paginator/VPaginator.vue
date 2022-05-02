<template>
  <nav 
    v-if="totalPages >=2"
    class="pagination is-centered"
    aria-label="Pagination">
    <v-paginator-nav @select="setPage(page - 1)"/>
    <ul class="pagination-list">
      <v-paginator-item
        :page="1"
        @select="setPage(1)"/>
      <v-paginator-seperator/>
      <template v-for="pageNumber in pages">
        <v-paginator-item
          :page="pageNumber"
          :key="pageNumber"
          @select="setPage(pageNumber)"/>
      </template>
      <v-paginator-seperator/>
      <v-paginator-item
        :page="totalPages"
        @select="setPage(totalPages)"/>
    </ul>
    <v-paginator-nav 
      type="next"
      @select="setPage(page + 1)"/>
  </nav>
</template>

<script>
import VFavicon from "../VFavicon";
import VPaginatorItem from "./VPaginatorItem";
import VPaginatorNav from "./VPaginatorNav";
import VPaginatorSeperator from "./VPaginatorSeperator";

export default {
  name: "Paginator",

  components: {
    VFavicon,
    VPaginatorItem,
    VPaginatorNav,
    VPaginatorSeperator
  },

  props: {
    value: {
      type: Number,
      required: false,
      default: 1
    },

    dataSet: {
      type: Object,
      required: true
    }
  },

  data() {
    return {
      page: this.value,
      totalPages: false,
      maxVisibleButtons: 3
    };
  },

  computed: {
    startPage() {
      if (this.page <= 4) return 2;

      if (this.page >= this.totalPages - 1) {
        return this.totalPages - this.maxVisibleButtons;
      }

      return this.page - 1;
    },

    endPage() {
      return Math.min(
        this.startPage + this.maxVisibleButtons - 1,
        this.totalPages - 1
      );
    },

    pages() {
      const range = [];

      for (let i = this.startPage; i <= this.endPage; i += 1) {
        range.push(i);
      }

      return range;
    }
  },

  watch: {
    dataSet() {
      this.page = this.dataSet.current;
      this.totalPages = this.dataSet.total;
    },

    page() {
      if (this.page !== this.dataSet.current) {
        this.broadcast().updateUrl();
      }
    }
  },

  methods: {
    broadcast() {
      return this.$emit("input", this.page);
    },

    updateUrl() {
      history.pushState({ page: this.page }, null, "?page=" + this.page);
    },

    setPage(page) {
      this.page = page;
    }
  }
};
</script>
