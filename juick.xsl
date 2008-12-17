<?xml version="1.0" encoding="utf-8"?>
	<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

		<xsl:param name="count" select="5"/>
		<xsl:param name="target" select="self"/>

		<xsl:template match="channel">
			<xsl:variable name="link" select="link"/>
			<strong><a target="_{$target}" href="{$link}"><xsl:value-of select="description"/></a></strong>
			<xsl:apply-templates select="item" />
		</xsl:template>
		
		<xsl:template match="item">
			<xsl:if test="not(position() > $count)">
				<xsl:variable name="link" select="link"/>
				<dl><dt><a target="_{$target}" href="{$link}"><xsl:value-of select="substring(pubDate,6,20)"/></a></dt><dd><xsl:value-of select="description"/></dd></dl>
			</xsl:if>	
		</xsl:template>
		
</xsl:stylesheet>	