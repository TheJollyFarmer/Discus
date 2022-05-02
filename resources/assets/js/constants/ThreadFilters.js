export default {
  ALL: {
    icon: "layer-group",
    label: "All Threads",
    linkData: ""
  },

  PERSONAL: {
    icon: "user-edit",
    label: "My Threads",
    linkData: { by: "" }
  },

  POPULAR: {
    icon: "fire",
    label: "Popular Threads",
    linkData: { popular: 1 }
  },

  UNANSWERED: {
    icon: "reply",
    label: "Unanswered Threads",
    linkData: { unanswered: 1 }
  }
};
