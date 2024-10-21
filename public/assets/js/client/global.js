$(function () {
  $(".cart-count").text(1);

  const fetchCountCart = () => {};
});

const formatPrice = (price) => {
  return `${price.toLocaleString("en-US")}đ`;
};

// config toastr
toastr.options = {
  closeButton: true,
  debug: false,
  newestOnTop: true,
  progressBar: true,
  positionClass: "toast-top-center",
  preventDuplicates: true,
  onclick: null,
  showDuration: "300",
  hideDuration: "1000",
  timeOut: "5000",
  extendedTimeOut: "1000",
  showEasing: "swing",
  hideEasing: "linear",
  showMethod: "fadeIn",
  hideMethod: "fadeOut",
};
