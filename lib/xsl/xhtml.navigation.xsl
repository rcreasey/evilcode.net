<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:php="http://php.net/xsl"
    xmlns:navigation="http://www.evilcode.net/Exhibition/namespaces/navigation"
    extension-element-prefixes="php navigation">

<!-- NAVIGATION -->
 <xsl:template match="navigation:navigation">
   <ul id="{@style}">
    <xsl:apply-templates />
   </ul>
 </xsl:template>

 <xsl:template match="navigation:text">
  <li><p><xsl:value-of select="navigation:text" /></p></li>
 </xsl:template>

 <xsl:template match="navigation:header">
  <li><h3><xsl:value-of select="navigation:heading" /></h3></li>
 </xsl:template>
 
 <xsl:template match="navigation:item">
  <li>
   <a href="{navigation:address}" title="{navigation:summary}">

    <xsl:choose>
     <xsl:when test="navigation:icon">
      <img src="{navigation:icon}" alt="{navigation:title}" />
      <h3><xsl:value-of select="navigation:title" /></h3>
      <xsl:value-of select="navigation:summary" />
     </xsl:when>

     <xsl:otherwise>
      <xsl:value-of select="navigation:title" />
     </xsl:otherwise>
    </xsl:choose>

   </a>
  </li>
 </xsl:template>

</xsl:stylesheet>

<!-- NAVIGATION
 <xsl:template match="navigation">

      <xsl:when test="box">
       <li class="box">
        <xsl:value-of select="box" />
       </li>
      </xsl:when>

      <xsl:otherwise>
       <li>
        <a href="{address}" title="{title}">

         <xsl:choose>
          <xsl:when test="icon">
           <img src="{icon}" alt="{title}" />
           <h3><xsl:value-of select="title" /></h3>
           <xsl:value-of select="summary" />
          </xsl:when>

          <xsl:otherwise>
           <xsl:value-of select="title" />
          </xsl:otherwise>
         </xsl:choose>

        </a>
       </li>
      </xsl:otherwise>
     </xsl:choose>

    </xsl:for-each>
   </ul>
  </xsl:for-each>

 </xsl:template>
-->
