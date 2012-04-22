<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:php="http://php.net/xsl"
    xmlns:form="http://www.evilcode.net/Exhibition/namespaces/form"
    xmlns:fn="http://www.w3.org/2005/02/xpath-functions"
    extension-element-prefixes="php form fn">

<!-- FORM -->
 <xsl:template match="form:form">
  <form action="{form:action}" method="{form:method}" enctype="{form:enctype}" accept-charset="{form:accept-charset}">
   <xsl:apply-templates />
  </form>
 </xsl:template>

<!-- FORM GROUP -->
 <xsl:template match="form:group">
  <table cellpadding="2" cellspacing="0" class="form">
   <caption><xsl:value-of select="form:heading" /></caption>
   <xsl:apply-templates />
  </table>
 </xsl:template>

<!-- FORM ELEMENT -->
 <xsl:template match="form:element">
  <xsl:choose>
   <xsl:when test="name(..) = 'form:group'">
   <tr>
    <xsl:if test="form:invalid">
     <xsl:attribute name="invalid">true</xsl:attribute>
    </xsl:if>
     <th>
      <xsl:value-of select="form:title" />
      <xsl:if test="form:required='true'">*</xsl:if>
     </th>
     <td>
      <xsl:if test="form:caption">
       <p class="small"><xsl:value-of select="form:caption" /></p>
      </xsl:if>
       <xsl:apply-templates />
     </td>
    </tr>
   </xsl:when>
   <xsl:otherwise>
    <xsl:apply-templates />
   </xsl:otherwise>
  </xsl:choose>
 </xsl:template>

<!-- FORM INPUT -->
 <xsl:template match="form:input">
  <input>
   <xsl:attribute name="type"><xsl:value-of select="form:type" /></xsl:attribute>
   <xsl:attribute name="name"><xsl:value-of select="form:name" /></xsl:attribute>
   <xsl:attribute name="value"><xsl:value-of select="form:value" /></xsl:attribute>
   <xsl:if test="form:maxlength">
    <xsl:attribute name="maxlength"><xsl:value-of select="form:maxlength" /></xsl:attribute>
   </xsl:if>
   <xsl:if test="form:accept">
    <xsl:attribute name="accept"><xsl:value-of select="form:accept" /></xsl:attribute>
   </xsl:if>
   <xsl:if test="form:alt">
    <xsl:attribute name="alt"><xsl:value-of select="form:alt" /></xsl:attribute>
   </xsl:if>
   <xsl:if test="form:checked">
    <xsl:attribute name="checked">true</xsl:attribute>
   </xsl:if>
   <xsl:if test="form:disabled">
    <xsl:attribute name="disabled">true</xsl:attribute>
   </xsl:if>
   <xsl:if test="form:readonly">
    <xsl:attribute name="readonly">true</xsl:attribute>
   </xsl:if>
   <xsl:if test="form:size">
    <xsl:attribute name="size"><xsl:value-of select="form:size" /></xsl:attribute>
   </xsl:if>
   <xsl:if test="form:src">
    <xsl:attribute name="src"><xsl:value-of select="form:src" /></xsl:attribute>
   </xsl:if>
  </input>
 </xsl:template>

<!-- FORM TEXTAREA -->
 <xsl:template match="form:textarea">
   <textarea>
    <xsl:attribute name="name"><xsl:value-of select="form:name" /></xsl:attribute>
    <xsl:attribute name="rows"><xsl:value-of select="form:rows" /></xsl:attribute>
    <xsl:attribute name="cols"><xsl:value-of select="form:cols" /></xsl:attribute>
    <xsl:if test="form:disabled">
    <xsl:attribute name="disabled">true</xsl:attribute>
    </xsl:if>
    <xsl:if test="form:readonly">
     <xsl:attribute name="readonly">true</xsl:attribute>
    </xsl:if>
    <xsl:value-of select="form:value" />
   </textarea>
 </xsl:template>

<!-- FORM SELECT -->
 <xsl:template match="form:select">
   <select>
    <xsl:if test="form:disabled">
     <xsl:attribute name="disabled"><xsl:value-of select="form:disabled" /></xsl:attribute>
    </xsl:if>
    <xsl:if test="form:multiple">
     <xsl:attribute name="multiple"><xsl:value-of select="form:multiple" /></xsl:attribute>
    </xsl:if>
    <xsl:if test="form:name">
     <xsl:attribute name="name"><xsl:value-of select="form:name" /></xsl:attribute>
    </xsl:if>
    <xsl:if test="form:size">
     <xsl:attribute name="size"><xsl:value-of select="form:size" /></xsl:attribute>
    </xsl:if>
    <xsl:for-each select="form:option">
     <option>
      <xsl:attribute name="value"><xsl:value-of select="form:value" /></xsl:attribute>
      <xsl:if test="form:disabled">
       <xsl:attribute name="disabled"><xsl:value-of select="form:disabled" /></xsl:attribute>
      </xsl:if>
      <xsl:if test="form:selected">
       <xsl:attribute name="selected"><xsl:value-of select="form:selected" /></xsl:attribute>
      </xsl:if>
      <xsl:value-of select="form:name" />
     </option>
    </xsl:for-each>
   </select>
 </xsl:template>

</xsl:stylesheet>