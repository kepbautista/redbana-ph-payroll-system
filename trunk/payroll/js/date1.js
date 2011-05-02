/* Javascript Date Selector
   by Warren Brown (03/01/2004 Radiokop South Africa)

   Script to place Month/day/year onto a web page, leap year enabled
*/

var date_arr = new Array;
var days_arr = new Array;

date_arr[0]=new Option("January",31);
date_arr[1]=new Option("February",28);
date_arr[2]=new Option("March",31);
date_arr[3]=new Option("April",30);
date_arr[4]=new Option("May",31);
date_arr[5]=new Option("June",30);
date_arr[6]=new Option("July",31);
date_arr[7]=new Option("August",30);
date_arr[8]=new Option("September",30);
date_arr[9]=new Option("October",31);
date_arr[10]=new Option("November",31);
date_arr[11]=new Option("December",30);

function fill_select1(f)
{
        document.writeln("<SELECT name=\"mon\"               onchange=\"update_days1(FRM)\">");
        for(x=0;x<12;x++)
                document.writeln("<OPTION value=\""+date_arr[x].value+"\">"+date_arr[x].text);
        document.writeln("</SELECT><SELECT name=\"day\"></SELECT>");
        selection=f.mon[f.mon.selectedIndex].value;
}

function update_days1(f)
{
        temp=f.day.selectedIndex;
        for(x=days_arr.length;x>0;x--)
        {
                days_arr[x]=null;
                f.day.options[x]=null;
         }
        selection=parseInt(f.mon[f.mon.selectedIndex].value);
        ret_val = 0;
        if(f.mon[f.mon.selectedIndex].value == 28)
        {
                year=parseInt(f.yrs.options[f.yrs.selectedIndex].value);
                if (year % 4 != 0 || year % 100 == 0 ) ret_val=0;
                else
                        if (year % 400 == 0)  ret_val=1;
                        else
                                ret_val=1;
        }
        selection = selection + ret_val;
        for(x=1;x < selection+1;x++)

        {
                days_arr[x-1]=new Option(x);
                f.day.options[x-1]=days_arr[x-1];
        }
        if (temp == -1) f.day.options[0].selected=true;
        else
             f.day.options[temp].selected=true;
}
function year_install1(f)
{
        document.writeln("<SELECT name=\"yrs\" onchange=\"update_days1(FRM)\">")
        for(x=1970;x<2011;x++) document.writeln("<OPTION value=\""+x+"\">"+x);
        document.writeln("</SELECT>");
        update_days1(f)
}