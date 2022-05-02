import moment from "moment";

export default {
  capitalise: string => string.charAt(0).toUpperCase() + string.slice(1),
  day: timestamp => moment(timestamp).format("dddd"),
  localTime: timestamp => moment(timestamp + "Z").fromNow(),
  time: timestamp => moment(timestamp).format("H:mm"),
  timestamp: () => moment().format("Y-M-D HH:mm:ss"),

  truncate(text, stop, clamp) {
    return text.slice(0, stop) + (stop < text.length ? clamp || "..." : "");
  },

  isMoment(notification) {
    let notificationTime = moment(notification);
    let today = moment().subtract(24, "h");

    return notificationTime.isBefore(today);
  }
};
