//*****************************************************无限联动JS****************************//
function getRoute(dic, value, mode)
{
    var strRoute, intDepth = -1;
    for (var i = dic.length - 1; i > -1; i--)
    {
        if (intDepth > -1)
        {
            if (intDepth == 0)
                return(strRoute);
            if (dic[i][0] < intDepth)
            {
                strRoute = i + "," + strRoute;
                intDepth--;
            }
        }
        else
        {
            if (dic[i][mode] == value)
            {
                strRoute = i.toString();
                intDepth = dic[i][0];
            }
        }
    }
    return(strRoute);
}
function getRoutes(dic, route, mode)
{
    var strRoute = "", depth = 0;
    var arrRoute = route.split(",");
    var intDepth = arrRoute.length - 1;
    for (var i = 0; i < dic.length; i++)
    {
        if (dic[i][mode] == arrRoute[depth])
        {
            if (strRoute)
                strRoute += "," + i;
            else
                strRoute = i.toString();
            if (depth == intDepth)
                return(strRoute);
            else
                depth++;
        }
    }
    return(strRoute);
}
function drawSelect(obj, dicName)
{
    var argv = drawSelect.arguments;
    var argc = drawSelect.arguments.length;
    var mode = (argc > 2) ? argv[2] : 0;
    var name = (argc > 3) ? argv[3] : "";
    var value = (argc > 4) ? argv[4] : "";
    var tips = (argc > 5) ? argv[5] : "";
    var datatype = (argc > 6) ? argv[6] : "";
    var msg = (argc > 7) ? argv[7] : "";

    var dic = eval(dicName), objValue = "";
    switch (mode)
    {
        case 0:
            value = getRoute(dic, value, 2);
            mode = 5;
            break;
        case 1:
            value = getRoutes(dic, value, 1);
            mode = 6;
            break;
        case 2:
            value = getRoute(dic, value, 1);
            mode = 7;
            break;
        case 3:
            value = getRoutes(dic, value, 2);
            mode = 8;
            break;
    }
    var strRoute = "", arrRoute = new Array();
    if (value)
        arrRoute = value.split(",");
    var strHtml = "", arrHtml = new Array();
    var intDepth, strTitle, strValue, j, selDepth = 0;
    for (var i = 0; i < dic.length; i++)
    {
        intDepth = dic[i][0];
        strTitle = dic[i][1];
        strValue = dic[i][2];
        if (intDepth == selDepth)
        {
            if (arrHtml[selDepth] == null)
            {
                arrHtml[selDepth] = "<select class=\"" + name + "_id\" onChange={drawSelect(this.parentNode,\"" + dicName + "\"," + mode + ",\"" + name + "\",this.value,\"" + tips + "\",\"" + datatype + "\",\"" + msg + "\")}>";
                if (tips)
                {
                    if (selDepth)
                        arrHtml[selDepth] += "<option value=\"" + strRoute + "\">" + tips + "</option>";
                    else
                        arrHtml[selDepth] += "<option value=\"\">" + tips + "</option>";
                    if (arrRoute[selDepth] == null)
                        arrRoute[selDepth] = -1;
                }
                else if (arrRoute[selDepth] == null)
                    arrRoute[selDepth] = i;
            }
            if (i == arrRoute[selDepth])
            {
                arrHtml[selDepth] += "<option value=\"" + strRoute + i.toString() + "\" selected>" + strTitle + "</option>";
                selDepth++;
                strRoute += i.toString() + ",";

                switch (mode)
                {
                    case 5:
                        objValue = strValue;
                        break;
                    case 6:
                        if (objValue)
                            objValue += "," + strTitle;
                        else
                            objValue = strTitle;
                        break;
                    case 7:
                        objValue = strTitle;
                        break;
                    case 8:
                        if (objValue)
                            objValue += "," + strValue;
                        else
                            objValue = strValue;
                        break;
                }
            }
            else
            {
                arrHtml[selDepth] += "<option value=\"" + strRoute + i.toString() + "\">" + strTitle + "</option>";
            }
        }
        else if (intDepth < selDepth)
        {
            selDepth = intDepth;
            strRoute = "";
            for (j = 0; j < selDepth; j++)
                strRoute += arrRoute[j] + ",";
            arrHtml[selDepth] += "<option value=\"" + strRoute + i.toString() + "\">" + strTitle + "</option>";
        }
    }
    for (i = 0; i < arrHtml.length; i++)
    {
        strHtml += arrHtml[i] + "</select>";
    }
    strHtml += "<input type=\"hidden\" value=\"" + objValue + "\" name=\"" + name + "\" id=\"" + name + "\" class=\"" + datatype + "\" title=\"" + msg + "\">";
    if (obj == null)
        document.write("<span>" + strHtml + "</span>");
    else
        obj.innerHTML = strHtml;
}
function drawRootItem(dic, value)
{
    for (var i = 0; i < dic.length; i++)
    {
        if (dic[i][0] == 0)
        {
            document.write("<option value=\"" + dic[i][2] + "\"");
            if (dic[i][2] == value)
                document.write(" selected");
            document.write(">" + dic[i][1] + "</option>");
        }
    }
}
