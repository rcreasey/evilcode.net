<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:php="http://php.net/xsl"
    xmlns:paras="http://evilcode.net/exhibition/namespaces/paras"
    extension-element-prefixes="php paras">

<!-- PARA -->
 <xsl:template match="paras:paras">

  <xsl:for-each select="paras:para">
  <xsl:choose>
    <xsl:when test="../@markup = 'raw'">
      <xsl:copy-of select="node()" />
    </xsl:when>
    <xsl:when test="../@class">
      <div class="{../@class}"><xsl:value-of select="." /></div>
    </xsl:when>

    <xsl:otherwise>
      <xsl:value-of select="." />
    </xsl:otherwise>
  </xsl:choose>
  </xsl:for-each>
 </xsl:template>

</xsl:stylesheet>
