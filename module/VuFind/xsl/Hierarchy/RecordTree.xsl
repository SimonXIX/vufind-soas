<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl">   
 
    <xsl:template match="/">
        <root>
        <xsl:apply-templates select="//root">
        </xsl:apply-templates>
        </root>
    </xsl:template>

    <xsl:template match="item">
        <xsl:variable name="id" select="@id" />
        <xsl:variable name="isCollection" select="@isCollection" />
        <xsl:variable name="baseModule">
          <xsl:choose>
            <xsl:when test="$context = 'Record'">
                <xsl:choose>
                    <xsl:when test="$isCollection = 'true'">Collection</xsl:when>
                    <xsl:otherwise>Record</xsl:otherwise>
                </xsl:choose>
            </xsl:when>
            <xsl:otherwise>Collection</xsl:otherwise>
          </xsl:choose>
        </xsl:variable>
        <item>
          <content>
                        
              <xsl:variable name="level" select="@level" />
		  <xsl:variable name="type">
       		<xsl:choose>
           		<xsl:when test="$level = 'File' or $level = 'Item'">Record</xsl:when>
           		<xsl:otherwise>Collection</xsl:otherwise>
         	</xsl:choose>
	      </xsl:variable>
		   

              <name class="JSTreeID"><xsl:value-of select="$id"/></name>
              <name href="{$baseURL}/{$baseModule}/{$id}/Description#tabnav{$type}" title="{$titleText}">
                  <xsl:value-of select="./content/name" />
              </name>
          </content>
          <xsl:apply-templates select="item"/>
      </item>
    </xsl:template>
    
</xsl:stylesheet>