<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:php="http://php.net/xsl"
    xmlns:table="http://www.evilcode.net/Exhibition/namespaces/table"
    extension-element-prefixes="php table">

<!-- TABLE -->
 <xsl:template match="table:table">
  <table>
   <xsl:attribute name="cellspacing">0</xsl:attribute>
   <xsl:attribute name="id"><xsl:value-of select="table:title" /></xsl:attribute>
   <xsl:if test="table:css_class">
    <xsl:attribute name="class"><xsl:value-of select="table:css_class" /></xsl:attribute>
   </xsl:if>

   <xsl:if test="table:overview">
    <caption><xsl:value-of select="table:overview" /></caption>
   </xsl:if>

   <xsl:variable name="displayCeiling">
   <xsl:choose>
     <xsl:when test="@pageable"><xsl:value-of select="@pageable * @page" /></xsl:when>
     <xsl:otherwise><xsl:value-of select="count(table:body/table:row)" /></xsl:otherwise>
   </xsl:choose>
   </xsl:variable>

   <xsl:variable name="displayStart">
   <xsl:choose>
     <xsl:when test="@page"><xsl:value-of select="(@page * @pageable) - @pageable" /></xsl:when>
     <xsl:otherwise>0</xsl:otherwise>
   </xsl:choose>
   </xsl:variable>

   <xsl:if test="table:header">
   <xsl:for-each select="table:header">
   <thead>
   <tr>
     <xsl:if test="table:css_class">
     <xsl:attribute name="class"><xsl:value-of select="table:css_class" /></xsl:attribute>
     </xsl:if>

     <xsl:for-each select="table:cell">
     <td>
       <xsl:if test="../table:span">
       <xsl:attribute name="colspan"><xsl:value-of select="../table:span" /></xsl:attribute>
       </xsl:if>

       <xsl:if test="table:css_class">
       <xsl:attribute name="class"><xsl:value-of select="table:css_class" /></xsl:attribute>
       </xsl:if>
       <xsl:value-of select="table:data" />
     </td>
     </xsl:for-each>
   </tr>
   </thead>
   </xsl:for-each>
   </xsl:if>

   <xsl:for-each select="table:body">

    <xsl:if test="table:row">
    <tbody>
    <xsl:for-each select="table:row">
    <xsl:if test="($displayStart &lt;= position()) and (position() &lt;= $displayCeiling)">
      <xsl:variable name="rowClass">
        <xsl:call-template name="getRowClass" />
      </xsl:variable>
      <tr class="{$rowClass}">
        <xsl:if test="table:css_class">
        <xsl:attribute name="class"><xsl:value-of select="table:css_class" /></xsl:attribute>
        </xsl:if>

        <xsl:for-each select="table:cell">
        <td>
          <xsl:if test="table:css_class">
          <xsl:attribute name="class"><xsl:value-of select="table:css_class" /></xsl:attribute>
          </xsl:if>
          <xsl:value-of select="table:data" />
        </td>
        </xsl:for-each>
      </tr>
    </xsl:if>
    </xsl:for-each>
    </tbody>
    </xsl:if>

   </xsl:for-each>

   <xsl:if test="table:footer">
   <xsl:for-each select="table:footer">
   <tfoot>
   <tr>
     <xsl:if test="table:css_class">
     <xsl:attribute name="class"><xsl:value-of select="table:css_class" /></xsl:attribute>
     </xsl:if>

     <xsl:for-each select="table:cell">
     <td>
       <xsl:if test="../table:span">
       <xsl:attribute name="colspan"><xsl:value-of select="../table:span" /></xsl:attribute>
       </xsl:if>

       <xsl:if test="table:css_class">
       <xsl:attribute name="class"><xsl:value-of select="table:css_class" /></xsl:attribute>
       </xsl:if>
       <xsl:value-of select="table:data" />
     </td>
     </xsl:for-each>
   </tr>
   </tfoot>
   </xsl:for-each>
   </xsl:if>


  </table>
 </xsl:template>

 <xsl:template name="getRowClass">
 <xsl:choose>
   <xsl:when test="position() mod 2 = 1"><xsl:text>odd</xsl:text></xsl:when>
   <xsl:otherwise><xsl:text>even</xsl:text></xsl:otherwise>
 </xsl:choose>
 </xsl:template>  

</xsl:stylesheet>
