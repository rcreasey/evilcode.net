<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    xmlns:php="http://php.net/xsl"
    xmlns:debug="http://www.evilcode.net/Exhibition/namespaces/debug"
    extension-element-prefixes="php debug">

<!-- DEBUG -->
 <xsl:template match="debug:debug">
  <table class="debug" id="array" cellspacing="0">
   <caption>Array Debug</caption>
   <xsl:for-each select="debug:array">
   <tr>
    <td class="label" valign="top"><xsl:value-of select="debug:name" /></td>
    <td class="status">
      <table class="variable">
      <thead>
      <tr>
        <td class="variable">Variable</td>
        <td class="value">Value</td>
      </tr>
      </thead>
      <tbody>
      <xsl:for-each select="debug:variable">
      <tr>
        <td class="variable"><xsl:value-of select="debug:name" /></td>
        <td class="value"><xsl:value-of select="debug:value" /></td>
      </tr>
      </xsl:for-each>
      </tbody>
      </table>
    </td>
   </tr>
   </xsl:for-each>
  </table>
  <xsl:if test="debug:string">
   <table class="debug" id="string" cellspacing="0">
    <caption>String Debug</caption>
    <xsl:if test="debug:string[@type='app']">
     <tr>
      <td class="label" valign="top">Application</td>
      <td class="status">
       <table class="variable"><tbody>
        <xsl:for-each select="debug:string[@type='app']">
         <tr><td><xsl:value-of select="." /></td></tr>
        </xsl:for-each>
       </tbody></table>
      </td>
     </tr>
    </xsl:if>
    <xsl:if test="debug:string[@type='info']">
     <tr>
      <td class="label" valign="top">Info</td>
      <td class="status">
       <table class="variable"><tbody>
        <xsl:for-each select="debug:string[@type='info']">
         <tr><td><xsl:value-of select="." /></td></tr>
        </xsl:for-each>
       </tbody></table>
      </td>
     </tr>
    </xsl:if>
   </table>
  </xsl:if>
 </xsl:template>

</xsl:stylesheet>