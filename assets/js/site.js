$(document).ready(function () {
  // find that url has search segement. if no, clear all the localstorage data. if not will do respective functions according to that.
  const hasSearch = window.location.pathname
    .split("/") // explode
    .filter(Boolean) // remove empty values
    .includes("search"); // check search term exist or not.

  const hasOnlyDetail = window.location.pathname
    .split("/") // explode
    .filter(Boolean) // remove empty values
    .includes("detail"); // check search term exist or not.

  const hasSearchOrDetails = window.location.pathname
    .split("/") // explode
    .filter(Boolean) // remove empty values
    .some((term) => term === "search" || term === "detail"); // check if "search" or "details" exist

  // remove the selected values from the storage --- by search selected. When coming to the detail page.
  if (hasOnlyDetail) {
    localStorage.setItem("searchType", "");
    localStorage.setItem("searchValue", "");
  }

  if (!hasSearchOrDetails) {
    localStorage.setItem("searchType", "");
    localStorage.setItem("searchValue", "");
    localStorage.setItem("searchStartDate", "");
    localStorage.setItem("searchEndDate", "");
    localStorage.setItem("adultCount", "");
    localStorage.setItem("childCount", "");
    localStorage.setItem("infantCount", "");
    localStorage.setItem("roomCount", "");

    localStorage.setItem("searchedNameValue", "");
    localStorage.setItem("searchedIcon", "");
    localStorage.setItem("searchedCountry", "");
  }
});

// get the value of search item in the search filter.
$(".searchContent").on("click", "button.dropdown-button", function () {
  const type = $(this).attr("type");
  const value = $(this).attr("value");
  const nameValue = $(this).attr("name-value").trim();
  const searchedIcon = $(this).attr("icon");
  const searchedCountry = $(this).attr("country");

  localStorage.setItem("searchType", type);
  localStorage.setItem("searchValue", value);
  localStorage.setItem("searchedNameValue", nameValue);
  localStorage.setItem("searchedIcon", searchedIcon);
  localStorage.setItem("searchedCountry", searchedCountry);
});

$(".search-button").on("click", function () {
  let searchType = localStorage.getItem("searchType");
  let searchValue = localStorage.getItem("searchValue");
  let searchStartDate = localStorage.getItem("searchStartDate");
  let searchEndDate = localStorage.getItem("searchEndDate");
  const adultCount = $(".adult-count").text();
  const childCount = $(".child-count").text();
  const infantCount = $(".infant-count").text();
  const roomCount = $(".room-count").text();

  localStorage.setItem("adultCount", adultCount);
  localStorage.setItem("childCount", childCount);
  localStorage.setItem("infantCount", infantCount);
  localStorage.setItem("roomCount", roomCount);

  let today = new Date();

  // Calculate the timestamp for the next Monday
  const nextMondayTimestamp = today.setDate(today.getDate() + (8 - today.getDay()));
  const nextWeekFirstDay = new Date(nextMondayTimestamp);

  // Calculate the timestamp for the fourth day of next week
  const nextWeekFourthDay = new Date(nextWeekFirstDay); // Create a new Date object
  nextWeekFourthDay.setDate(nextWeekFourthDay.getDate() + 4);

  searchType = searchType != "" ? searchType : 0;
  searchValue = searchValue != "" ? searchValue : 0;
  searchStartDate = searchStartDate || nextWeekFirstDay.toISOString().slice(0, 10);
  searchEndDate = searchEndDate || nextWeekFourthDay.toISOString().slice(0, 10);

  const prs = `st=${btoa(btoa(searchType))}&sv=${btoa(
    btoa(searchValue)
  )}&ssd=${btoa(btoa(searchStartDate))}&sed=${btoa(
    btoa(searchEndDate)
  )}&ac=${btoa(btoa(adultCount))}&cc=${btoa(btoa(childCount))}&rc=${btoa(
    btoa(roomCount)
  )}&ic=${btoa(btoa(infantCount))}`;
  const dynamicUrl = `${BASE_URL}search?prs=${btoa(prs)}`;
  window.location.href = dynamicUrl;
});

$(".common-search").on("click", function () {
  let searchType = localStorage.getItem("searchType");
  let searchValue = localStorage.getItem("searchValue");
  let searchStartDate = localStorage.getItem("searchStartDate");
  let searchEndDate = localStorage.getItem("searchEndDate");
  const adultCount = $(".common-adult-count").text();
  const childCount = $(".common-child-count").text();
  const infantCount = $(".common-infant-count").text();
  const roomCount = $(".common-room-count").text();

  localStorage.setItem("adultCount", adultCount);
  localStorage.setItem("childCount", childCount);
  localStorage.setItem("infantCount", infantCount);
  localStorage.setItem("roomCount", roomCount);

  let today = new Date();

  // Calculate the timestamp for the next Monday
  const nextMondayTimestamp = today.setDate(today.getDate() + (8 - today.getDay()));
  const nextWeekFirstDay = new Date(nextMondayTimestamp);

  // Calculate the timestamp for the fourth day of next week
  const nextWeekFourthDay = new Date(nextWeekFirstDay); // Create a new Date object
  nextWeekFourthDay.setDate(nextWeekFourthDay.getDate() + 4);

  searchType = searchType != "" ? searchType : 0;
  searchValue = searchValue != "" ? searchValue : 0;
  searchStartDate = searchStartDate || nextWeekFirstDay.toISOString().slice(0, 10);
  searchEndDate = searchEndDate || nextWeekFourthDay.toISOString().slice(0, 10);

  const prs = `st=${btoa(btoa(searchType))}&sv=${btoa(
    btoa(searchValue)
  )}&ssd=${btoa(btoa(searchStartDate))}&sed=${btoa(
    btoa(searchEndDate)
  )}&ac=${btoa(btoa(adultCount))}&cc=${btoa(btoa(childCount))}&rc=${btoa(
    btoa(roomCount)
  )}&ic=${btoa(btoa(infantCount))}`;
  const dynamicUrl = `${BASE_URL}search?prs=${btoa(prs)}`;
  window.location.href = dynamicUrl;
});

// select the price and room from the dropdown in the detail page.
$("a.js-dropdown-link.price-list").on("click", function () {
  const roomCount = $(this).attr("room-count");
  const roomPrice = $(this).attr("room-price");
  const roomIndex = $(this).attr("room-index");

  const totalSleepPax = $("#room-price-for" + roomIndex).attr('total-pax')

  let roomLabel = "rooms";
  if (roomCount == 1) {
    roomLabel = "room";
  }
  $(
    "a.js-dropdown-link.price-list.selected[room-index='" + roomIndex + "']"
  ).removeClass("selected");
  $(this).addClass("selected");
  $("#room-count-for" + roomIndex).html(`${roomCount} ${roomLabel} for ${totalSleepPax} Pax`);
  $("#room-price-for" + roomIndex).html(
    `${CURRENCY}${(parseFloat(roomPrice) + 0).toFixed(2)}`
  );
});

$("#check-availability-button").on("click", function () {
  const accomId = localStorage.getItem("accomId");
  let searchStartDate = localStorage.getItem("searchStartDate");
  let searchEndDate = localStorage.getItem("searchEndDate");
  const adultCount = $(".check-adult-count").text();
  const childCount = $(".check-child-count").text();
  const infantCount = $(".check-infant-count").text();
  const roomCount = $(".check-room-count").text();

  let today = new Date();
  searchStartDate =
    searchStartDate != ""
      ? searchStartDate
      : new Date(today.setDate(today.getDate())).toISOString().slice(0, 10);
  searchEndDate =
    searchEndDate != ""
      ? searchEndDate
      : new Date(today.setDate(today.getDate() + 10))
          .toISOString()
          .slice(0, 10);

  const prs = `ssd=${btoa(btoa(searchStartDate))}&sed=${btoa(
    btoa(searchEndDate)
  )}&ac=${btoa(btoa(adultCount))}&cc=${btoa(btoa(childCount))}&rc=${btoa(
    btoa(roomCount)
  )}&rid=${btoa(btoa(accomId))}&ic=${btoa(btoa(infantCount))}`;
  const dynamicUrl = `${BASE_URL}inquiry/main/internet-inquiry?prs=${btoa(
    prs
  )}`;
  window.location.href = dynamicUrl;
});
