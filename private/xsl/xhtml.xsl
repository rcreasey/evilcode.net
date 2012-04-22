<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:php="http://php.net/xsl"
    xmlns:navigation="http://www.evilcode.net/Exhibition/namespaces/navigation"
    xmlns:form="http://www.evilcode.net/Exhibition/namespaces/form"
    xmlns:table="http://www.evilcode.net/Exhibition/namespaces/table"
    xmlns:paras="http://evilcode.net/exhibition/namespaces/paras"
    xmlns:debug="http://www.evilcode.net/Exhibition/namespaces/debug"
    extension-element-prefixes="php navigation form table debug">
<xsl:output method="xml" encoding="UTF-8" omit-xml-declaration="yes" doctype-public="-//W3C//DTD XHTML 1.1//EN" doctype-system="http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd" indent="yes" />

<xsl:include href="xhtml.navigation.xsl" />
<xsl:include href="xhtml.form.xsl" />
<xsl:include href="xhtml.table.xsl" />
<xsl:include href="xhtml.paras.xsl" />
<xsl:include href="xhtml.debug.xsl" />

 <xsl:template match="/document">
  <html>
   <xsl:attribute name="xmlns">http://www.w3.org/1999/xhtml</xsl:attribute>
   <head>
    <title><xsl:if test="apptitle">
     <xsl:value-of select="apptitle" /></xsl:if>
     <xsl:if test="pagetitle">
     <xsl:text> :: </xsl:text><xsl:value-of select="pagetitle" />
     </xsl:if>
    </title>
    <link rel="stylesheet" type="text/css" href="/css/screen-corp/" />
   </head>

   <body>
    <div id="wrapper">
    <xsl:call-template name="header" />
    <xsl:apply-templates select="navigation:navigation" />

    <xsl:apply-templates />

    <xsl:call-template name="footer" />
    </div>
   </body>

  </html>
 </xsl:template>

 <xsl:template match="content">
  <div id="{@style}">
   <xsl:apply-templates />
  </div>
 </xsl:template>


<!-- HEADER -->
 <xsl:template name="header">
   <h1 id="header"><img src="/img/header-corp.png" alt="EVILCODE CORPORATION" /></h1>
 </xsl:template>


<!-- FOOTER -->
 <xsl:template name="footer">

  <xsl:if test="/document/@uri != '/'">
   <h1 id="footbanner"><xsl:text> </xsl:text></h1>
  </xsl:if>

  <div id="footer">
   <xsl:value-of select="footer" />
  </div>
 </xsl:template>

<!-- PARA -->
 <xsl:template match="paras">
  <xsl:for-each select="para">
   <xsl:value-of select="." />
  </xsl:for-each>
 </xsl:template>

<!-- ERROR -->
 <xsl:template match="error">
  <h1><xsl:value-of select="code" />
  <xsl:text> - </xsl:text>
  <xsl:value-of select="title" /></h1><br />
  <xsl:value-of select="description" />
 </xsl:template>

  <!-- Ignore anything not explicitly matched -->
  <xsl:template match="text()" />

</xsl:stylesheet>

<!-- DIRECTORY
 <xsl:template match="directory">
  <xsl:variable name="path" select="path" />
  <xsl:variable name="fspath" select="fspath" />
  <h2>Directory Listing of <xsl:copy-of select="$fspath" /></h2>
  <table class="ruler" id="directory">
   <thead>
   <tr>
    <td><strong>Filename</strong></td>
    <td><strong>Size</strong></td>
    <td><strong>Permissions</strong></td>
    <td><strong>Last Modified</strong></td>
   </tr>
   </thead>
   <tbody>
    <xsl:for-each select="descriptor">
    <tr>
     <td>
      <xsl:element name="a">
       <xsl:attribute name="href">
        <xsl:if test="type='directory'">
        <xsl:copy-of select="$path" /></xsl:if>
        <xsl:value-of select="name"/>
        <xsl:if test="type='directory'"><xsl:text>/</xsl:text></xsl:if>
       </xsl:attribute>
       <xsl:value-of select="name" />
       <xsl:if test="type='directory'"><xsl:text>/</xsl:text></xsl:if>
      </xsl:element>
     </td>
     <td><xsl:value-of select="size" /></td>
     <td><xsl:value-of select="permissions" /></td>
     <td><xsl:value-of select="modified" /></td>
    </tr>
    </xsl:for-each>
   </tbody>
  </table>
 </xsl:template>
-->
