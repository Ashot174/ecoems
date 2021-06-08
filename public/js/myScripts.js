$(document).ready(function()
{
    $("#substation_hotspot_summary th, #substation_hotspot_summary td").mouseover(function()
    {
        let targetIndex, elements;
         targetIndex = $(this).index() + 1;
         elements = $("#substation_hotspot_summary th,#substation_hotspot_summary td");
         elements.filter(":nth-child(" + 2 + ")").css("background-color", "#e498b2");
         elements.filter(":nth-child(" + 3 + ")").css("background-color", "#d8668b");
         elements.filter(":nth-child(" + 4 + ")").css("background-color", "#cc3366");
         elements.filter(":nth-child(" + 5 + ")").css("background-color", "#cc3366");
         elements.not(":nth-child(" + targetIndex + ")").css("background-color", "transparent")
    });
    $("#substation_hotspot_summary").mouseleave(function()
    {
        $("#substation_hotspot_summary th,#substation_hotspot_summary td").css("background-color", "transparent");
    });


    $("#substation_pid_summary th, #substation_pid_summary td").mouseover(function()
    {
        let targetIndex, elements;
        targetIndex = $(this).index() + 1;
        elements = $("#substation_pid_summary th,#substation_pid_summary td");
        elements.filter(":nth-child(" + 2 + ")").css("background-color", "#98b2e4");
        elements.filter(":nth-child(" + 3 + ")").css("background-color", "#668bd8");
        elements.filter(":nth-child(" + 4 + ")").css("background-color", "#3366cc");
        elements.not(":nth-child(" + targetIndex + ")").css("background-color", "transparent")
    });
    $("#substation_pid_summary").mouseleave(function()
    {
        $("#substation_pid_summary th,#substation_pid_summary td").css("background-color", "transparent");
    });

    $("#substation_defect_summary th, #substation_defect_summary td").mouseover(function()
    {
        let targetIndex, elements, th;
        targetIndex = $(this).index() + 1;
        th = $("#substation_defect_summary th");
        elements = $("#substation_defect_summary th,#substation_defect_summary td");
        elements.filter(":nth-child(" + targetIndex + ")").css("background-color", (this.dataset.color!==undefined) ?this.dataset.color:th.eq($(this).index()).data('color'));
        elements.not(":nth-child(" + targetIndex + ")").css("background-color", "transparent")
    });
    $("#substation_defect_summary").mouseleave(function()
    {
        $("#substation_defect_summary th,#substation_defect_summary td").css("background-color", "transparent");
    });


});
